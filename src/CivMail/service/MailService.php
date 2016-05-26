<?php

namespace CivMail\Service;

use Zend\Mail;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

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
}