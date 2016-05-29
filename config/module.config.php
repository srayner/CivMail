<?php

namespace CivMail;

return array(
    
    // Doctrine
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),
    
    'service_manager' => array(
        'factories' => array(
            'CivMail\MailService' => 'CivMail\Service\MailServiceFactory',
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'CivMail\Controller\Mail' => 'CivMail\Controller\MailController'
        ),
    ),
    
    // Console routes
    'console' => array(
        'router' => array(
            'routes' => array(
                'processmailqueue' => array(
                    'type'    => 'simple',
                    'options' => array(
                        'route'    => 'processmailqueue',
                        'defaults' => array(
                            '__NAMESPACE__' => 'CivMail\Controller',
                            'controller' => 'CivMail\Controller\Mail',
                            'action'     => 'processqueue'
                        ),
                    ),
                ),
            ),
        ),
    ),
);
