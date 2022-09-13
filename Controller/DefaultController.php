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
                'Authorization' => 'Bearer 5d1d400be387648f4c8fa28ea3c7cc52-us1',
                'Content-Type'  => 'application/json'
            ],
        ]);

        $response = $client->request(
            'GET',
            'https://us1.api.mailchimp.com/3.0/campaigns/81432f3aad/content?fields=html'
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