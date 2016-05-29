<?php

namespace CivMail\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class MailController extends AbstractActionController
{
    public function processqueueAction()
    {
        $mailService = $this->getServiceLocator()->get('CivMail\MailService');
        $mailService->sendQueue();
    }
}

