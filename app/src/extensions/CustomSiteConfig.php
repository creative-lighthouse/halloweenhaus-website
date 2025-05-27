<?php

namespace App;

use SilverStripe\Core\Extension;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;

/**
 * Class \App\CustomSiteConfig
 *
 * @property SiteConfig|CustomSiteConfig $owner
 * @property string $DateText
 * @property string $PlaceText
 * @property bool $ShowBanner
 * @property string $BannerText
 * @property string $AckMessageSubject
 * @property string $AckMessageContent
 * @property string $TicketMessageSubject
 * @property string $TicketMessageContent
 * @property string $NewRegisterMessageSubject
 * @property string $NewRegisterMessageContent
 * @property bool $EmailsActive
 * @property string $EventAdminEmail
 */
class CustomSiteConfig extends Extension
{

    private static $db = [
        'DateText' => 'Varchar(255)',
        "PlaceText" => "Varchar(255)",
        "ShowBanner" => "Boolean",
        "BannerText" => "HTMLText",
        'AckMessageSubject' => 'Varchar(255)',
        'AckMessageContent' => 'HTMLText',
        'TicketMessageSubject' => 'Varchar(255)',
        'TicketMessageContent' => 'HTMLText',
        'NewRegisterMessageSubject' => 'Varchar(255)',
        'NewRegisterMessageContent' => 'HTMLText',
        'EmailsActive' => 'Boolean',
        'EventAdminEmail' => 'Varchar(255)',
    ];

    private static $defaults = [
        'EmailsActive' => true,
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab("Root.Main", TextField::create("DateText", "Date Text"));
        $fields->addFieldToTab("Root.Main", TextField::create("PlaceText", "Place Text"));
        $fields->addFieldToTab("Root.Main", CheckboxField::create("ShowBanner", "Show Banner"));
        $fields->addFieldToTab("Root.Main", HTMLEditorField::create("BannerText", "Banner Text"));
        $fields->addFieldToTab('Root.Event Emails', CheckboxField::create('EmailsActive', 'E-Mails aktiviert'));
        $fields->addFieldToTab('Root.Event Emails', TextField::create('EventAdminEmail', 'Event Admin Emailadresse'));
        $fields->addFieldToTab('Root.Event Emails', TextField::create('AckMessageSubject', 'Empfangsbestätigung Betreff'));
        $fields->addFieldToTab('Root.Event Emails', HTMLEditorField::create('AckMessageContent', 'Empfangsbestätigung Inhalt'));
        $fields->addFieldToTab('Root.Event Emails', TextField::create('TicketMessageSubject', 'Ticket-Email Betreff'));
        $fields->addFieldToTab('Root.Event Emails', HTMLEditorField::create('TicketMessageContent', 'Ticket-Email Inhalt'));
        $fields->addFieldToTab('Root.Event Emails', TextField::create('NewRegisterMessageSubject', 'Neue Anmeldung Betreff'));
        $fields->addFieldToTab('Root.Event Emails', HTMLEditorField::create('NewRegisterMessageContent', 'Neue Anmeldung Inhalt'));
    }
}
