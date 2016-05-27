<?php

namespace CivMail\Service;

use Zend\Mail;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class MailService
{
    protected $options;
    
    public function __construct($options)
    {
        $this->options = $options;
    }
    
    public function sendMail($to, $from, $subject, $body)
    {
        $message = new Mail\Message();
        $message->setBody($body);
        $message->setFrom($from);
        $message->addTo($to);
        $message->setSubject($subject);

        $transport = new SmtpTransport();
        
        $transport->setOptions(new SmtpOptions($this->options));
        $transport->send($message);
    }
    
    public function sendMessage(Array $mail)
    {
        // Build the message body
        $parts = $mail['parts'];
        $mimeParts = array();
        foreach($parts as $part) {
            $mimePart = new MimePart($part['content']);
            $mimePart->type = $part['type'];
            $mimeParts[] = $part;
        }
        $body = new MimeMessage();
        $body->setParts($mimeParts);
        
        // Build the message.
        $message = new  Mail\Message();
        $message->setBody($body);
        $message->setFrom($mail['from']);
        $message->addTo($mail['to']);
        $message->setSubject($mail['subject']);

        // Create the transport and send.
        $transport = new SmtpTransport();
        $transport->setOptions(new SmtpOptions($this->options));
        $transport->send($message);
        
        die(var_dump($mimeParts));
        
    }
}