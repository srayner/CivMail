<?php

namespace CivMail\Service;

use DateTime;
use CivMail\Entity;

use Zend\Mail;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class MailService
{
    protected $options;
    protected $entityManager;
    
    public function __construct($options, $entityManager)
    {
        $this->options = $options;
        $this->entityManager = $entityManager;
    }
    
    public function sendQueue()
    {
        $queue = $this->entityManager->getRepository('CivMail\Entity\Mail')->findBy(array(
            'status' => Entity\Mail::QUEUED
        ));
        $i = 0;
        foreach($queue as $mail) {
            $this->sendMail($mail);
            $mail->setStatus(Entity\Mail::SENT);
            $this->entityManager->persist($mail);
            $i++;
        }
        $this->entityManager->flush();
        return $i;
    }
    
    public function sendMail($mail)
    {
        // Build the message body
        $mimeParts = array();
        foreach($mail->getParts() as $part) {
            $mimePart = new MimePart($part->getContent());
            $mimePart->type = $part->getType();
            $mimeParts[] = $mimePart;
        }
        $body = new MimeMessage();
        $body->setParts($mimeParts);
        
        // Build the message.
        $message = new  Mail\Message();
        $message->setBody($body);
        
        // Set the participants
        foreach($mail->getParticipants() as $participant) {
            if ($participant->getComposition() == 'to') {
              $message->addTo($participant->getAddress(), $participant->getName());    
            }
            if ($participant->getComposition() == 'cc') {
              $message->addCc($participant->getAddress(), $participant->getName());    
            }
            if ($participant->getComposition() == 'bcc') {
              $message->addBcc($participant->getAddress(), $participant->getName());    
            }
            if ($participant->getComposition() == 'from') {
              $message->addFrom($participant->getAddress(), $participant->getName());    
            }
        }

        // Set the subject
        $message->setSubject($mail->getSubject());

        // Create the transport and send.
        $transport = new SmtpTransport();
        $transport->setOptions(new SmtpOptions($this->options));
        $transport->send($message);
    }
    
    public function createMail($subject, $replyName, $replyAddress)
    {
        $mail = new Entity\Mail();
        $mail->setSubject($subject)
             ->setReplyName($replyName)
             ->setReplyAddress($replyAddress);
        return $mail;
    }
    
    public function addParticipant($mail, $composition, $name, $address)
    {
        $participant = new Entity\MailParticipant();
        $participant->setComposition($composition)
                    ->setName($name)
                    ->setAddress($address);
        $mail->addParticipant($participant);
        return $this;
    }
    
    public function addContent($mail, $type, $content)    
    {
        $part = new Entity\MailPart();
        $part->setType($type)
             ->setContent($content);
        $mail->addPart($part);
        return $this;
    }
    
    public function persist($mail, $flush = true)
    {
        $mail->setStatus(Entity\Mail::QUEUED)
             ->setCreatedTime(new DateTime());
        $this->entityManager->persist($mail);
        if ($flush) {
            $this->entityManager->flush();
        };
    }
}