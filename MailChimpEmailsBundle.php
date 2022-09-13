<?php
namespace MauticPlugin\MailChimpEmailsBundle;
use Mautic\PluginBundle\Bundle\PluginBundleBase;

/**
 * Bring Your Emails from Mailchimp to Mautic
 * @author Kesc23 (Kevin Campos) <kevin@felizex.com.br>
 */
class MailChimpEmailsBundle extends PluginBundleBase{
    
    /**
     * @var String The prefix for the new emails
     */
    const PREFIX = 'mcemail=';

    /**
     * @var String SECURITY: The Mautic Security object
     */
    const SECURITY = 'mautic.security';

    const ACCESS = [
        'create_emails' => 'email:emails:create',
        'full' => 'mautic:core:permissions:full',
    ];

    /**
     * @var array Standard Mautic email Tokens
     */
    const TOKENS = [
        "unsubscribe_text",
        "webview_text",
        "signature",
        "subject",
        "unsubscribe_url",
        "webview_url",
        "contactfield=companyaddress1",
        "contactfield=companyaddress2",
        "contactfield=address1",
        "contactfield=address2",
        "contactfield=companyannual_revenue",
        "contactfield=attribution",
        "contactfield=attribution_date",
        "contactfield=city",
        "contactfield=companycity",
        "contactfield=companyemail",
        "contactfield=companyname",
        "contactfield=country",
        "contactfield=companycountry",
        "contactfield=last_active",
        "contactfield=companydescription",
        "contactfield=email",
        "contactfield=facebook",
        "contactfield=fax",
        "contactfield=companyfax",
        "contactfield=firstname",
        "contactfield=foursquare",
        "contactfield=companyindustry",
        "contactfield=instagram",
        "contactfield=lastname",
        "contactfield=linkedin",
        "contactfield=mobile",
        "contactfield=companynumber_of_employees",
        "contactfield=phone",
        "contactfield=companyphone",
        "contactfield=points",
        "contactfield=position",
        "contactfield=preferred_locale",
        "contactfield=timezone",
        "contactfield=company",
        "contactfield=skype",
        "contactfield=state",
        "contactfield=companystate",
        "contactfield=title",
        "contactfield=twitter",
        "contactfield=website",
        "contactfield=companywebsite",
        "contactfield=zipcode",
        "contactfield=companyzipcode",
        "ownerfield=email",
        "ownerfield=firstname",
        "ownerfield=lastname",
        "ownerfield=position",
        "ownerfield=signature",
    ];
}