<?php

namespace App;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

/**
 * Class \App\CustomSiteConfig
 *
 * @property \SilverStripe\SiteConfig\SiteConfig|\App\CustomSiteConfig $owner
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
 */
class CustomSiteConfig extends DataExtension
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
        $fields->addFieldToTab("Root.Main", new TextField("DateText", "Date Text"));
        $fields->addFieldToTab("Root.Main", new TextField("PlaceText", "Place Text"));
        $fields->addFieldToTab("Root.Main", new CheckboxField("ShowBanner", "Show Banner"));
        $fields->addFieldToTab("Root.Main", new HTMLEditorField("BannerText", "Banner Text"));
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
