<?php

namespace MauticPlugin\MailChimpEmailsBundle\Controller;

use Symfony\Component\HttpClient\HttpClient;
use Mautic\CoreBundle\Controller\CommonController;
use MauticPlugin\MailChimpEmailsBundle\MailChimpEmailsBundle as MCE;

class DefaultController extends CommonController{

    public function emailsAction(){
        $sec = $this->get( MCE::SECURITY );

        if( ! $sec->isGranted( 'mautic:core:permissions:view' ) ){
            return $this->postActionRedirect();
        }

        $client = HttpClient::create([
            'headers' => [
                'Content-Type'  => 'application/json'
            ],
        ]);

        $response = $client->request(
            'GET',
        );

        return $this->delegateView(
            array(
                'contentTemplate' => 'MailChimpEmailsBundle:main:main.html.php',
                'viewParameters'  => array(
                    'response' => $response
                ),
            )
        );
    }

    public function adminAction(){
        $sec = $this->get( MCE::SECURITY );

        if( ! $sec->isGranted( 'mautic:core:permissions:full' ) ){
            return $this->postActionRedirect();
        }

        return $this->delegateView(
            array(
                'contentTemplate' => 'MailChimpEmailsBundle:admin:admin.html.php',
            )
        );
    }
}
