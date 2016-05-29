<?php

namespace CivMail\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MailServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config')['CivMail']['transport_options'];
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        return new MailService($config, $entityManager);   
    }
}