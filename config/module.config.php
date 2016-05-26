<?php

return array(
    
    
    'service_manager' => array(
        'factories' => array(
            'CivMail\MailService' => 'CivMail\Service\MailServiceFactory',
        ),
    ),
);
