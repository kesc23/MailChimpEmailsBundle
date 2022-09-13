<?php

namespace MauticPlugin\MailChimpEmailsBundle\EventListener;

use \DOMDocument;
use \ReflectionMethod;
use MauticPlugin\MailChimpEmailsBundle\MailChimpEmailsBundle as MCE;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpClient\Response;
use Symfony\Component\HttpClient\HttpClient;
use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Entity\Email;
use Mautic\EmailBundle\Event\EmailSendEvent;
use Mautic\EmailBundle\Event\EmailBuilderEvent;

class EmailSubscriber implements EventSubscriberInterface{

    /**
     * @var string
     */
    private static $contactFieldRegex = "{".MCE::PREFIX.'(.*?)}';

    /**
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return array(
            EmailEvents::EMAIL_ON_BUILD   => array( 'onEmailBuild', 5 ),
            EmailEvents::EMAIL_ON_SEND    => array( 'onEmailGenerate', 5 ),
            EmailEvents::EMAIL_ON_DISPLAY => array( 'onEmailGenerate', 5 )
        );
    }

    public function onEmailBuild(EmailBuilderEvent $event){

        if( $event->tokensRequested( self::$contactFieldRegex ) ){
            $event->addToken( '{mcemail}', 'MailChimpEmail' );
        }

    }

    public function onEmailGenerate(EmailSendEvent $event) {

        $tokens = ['mcemail', MCE::PREFIX."1238ad9"];
        $or_tokens = implode( "|", $tokens );

        if( ! preg_match( "/{{$or_tokens}}/", $event->getContent() ) ){
            return;
        }

        $client = HttpClient::create([
            'headers' => [
                'Content-Type'  => 'application/json'
            ],
        ]);

        /**
         * @var Response
         */
        $response = $client->request(
            'GET',
        );

        $res = ( json_decode( $response->getContent() ) )->html;
        
        $methods = (object) [
            'getSubject'     => new ReflectionMethod( Email::class, 'getSubject' ),
            'getDescription' => new ReflectionMethod( Email::class, 'getDescription' ),
        ];

        $mce = [
            '\*\|MC:SUBJECT\|\*' => 'getSubject',
            '\*\|MC:MC_PREVIEW_TEXT\|\*' => 'getDescription'
        ];

        foreach( $mce as $regex => $method ){
            if( preg_match( "/{$regex}/", $res ) ){
                $res = preg_replace( "/{$regex}/", $methods->$method->invoke( $event->getEmail() ), $res );
            }
        }


        if( class_exists( 'DOMDocument' ) ){
            $dom = new DOMDocument();

            @$dom->loadHTML( "{$res}", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );

            $eles = $dom->getElementsByTagName( 'center' );

            if ( $eles->item(1) ) {
                $dom->getElementsByTagName( 'body' )
                    ->item(0)
                    ->removeChild( $eles->item( 1 ) );
            }

            $res = $dom->saveHTML();
        }

        foreach( MCE::TOKENS as $i => $token ){
            if( preg_match( "/%7B{$token}%7D/", $res ) ){
                $res = preg_replace( "/%7B{$token}%7D/", "{{$token}}" , $res );
            }
        }

        $tokenList = [ '{mcemail}' => $res ];

        $event->setContent( $res );

        if ( count($tokenList) ) {
            $event->addTokens($tokenList);
            unset($tokenList);
        }
    }
}