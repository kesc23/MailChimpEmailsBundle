<?php 

use MauticPlugin\MailChimpEmailsBundle\EventListener\EmailSubscriber;
use MauticPlugin\MailChimpEmailsBundle\MailChimpEmailsBundle as MCE;

return array(
    'name'        => 'MailChimp Emails',
    'description' => 'Create/Rescue your emails in MailChimp and bring\'em to Mautic',
    'author'      => 'Kesc23 (Kevin Campos)',
    'version'     => '1.0.0',
    'routes'      => [
        'main'    => [
            'plugin_mailchimpemails_emails' => [
                'path'       => '/mcemails/emails',
                'controller' => 'MailChimpEmailsBundle:Default:emails',
            ],
            'plugin_mailchimpemails_admin' => [
                'path'       => '/mcemails/admin',
                'controller' => 'MailChimpEmailsBundle:Default:admin',
            ],
        ],
    ],
    'menu'        => [
        'main'    => [
            'priority' => 4,
            'items' => [
                'plugin.mailchimpemails.emails' => array(
                    'id'        => 'plugin_mailchimpemails_emails',
                    'iconClass' => 'fa-envelope',
                    'access'    => MCE::ACCESS['create_emails'],
                    'route'     => 'plugin_mailchimpemails_emails'
                )
            ],
        ],
        'admin'   => [
            'plugin.mailchimpemails.admin' => array(
                'id'        => 'plugin_mailchimpemails_admin',
                'iconClass' => 'fa-envelope',
                'access'    => MCE::ACCESS['full'],
                'route'     => 'plugin_mailchimpemails_admin'
            )
        ],
    ],
    'services'   => [
        'events' => [
            'plugin.mailchimpemails.email.subscriber' => [
                'class' => EmailSubscriber::class,
            ],
        ]
    ]
);