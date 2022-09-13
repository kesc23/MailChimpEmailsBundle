<?php

use Mautic\CoreBundle\Templating\Helper\SlotsHelper;

$view->extend('MauticCoreBundle:Default:content.html.php');

/**
 * @var SlotsHelper
 */
$slots = $view['slots'];

$slots->set( 'headerTitle', "MailChimp Emails" );

$c = $response;

?>
<pre>
</pre>