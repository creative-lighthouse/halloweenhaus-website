<?php

namespace App\Extensions;

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
 * @property ?string $DateText
 * @property ?string $PlaceText
 * @property bool $ShowBanner
 * @property ?string $BannerText
 * @property ?string $AckMessageSubject
 * @property ?string $AckMessageContent
 * @property ?string $TicketMessageSubject
 * @property ?string $TicketMessageContent
 * @property ?string $NewRegisterMessageSubject
 * @property ?string $NewRegisterMessageContent
 * @property bool $EmailsActive
 * @property ?string $EventAdminEmail
 * @property int $MaxGroupSize
 * @property ?string $SocialTikTok
 * @property ?string $SocialInstagram
 * @property ?string $SocialFacebook
 * @property ?string $SocialLinkedIn
 * @property ?string $SocialYoutube
 */
class CustomSiteConfig extends Extension
{

    private static $db = [
        'DateText' => 'Varchar(255)',
        "PlaceText" => "Varchar(255)",
        "ShowBanner" => "Boolean",
        "BannerText" => "Varchar(511)",
        'AckMessageSubject' => 'Varchar(255)',
        'AckMessageContent' => 'HTMLText',
        'TicketMessageSubject' => 'Varchar(255)',
        'TicketMessageContent' => 'HTMLText',
        'NewRegisterMessageSubject' => 'Varchar(255)',
        'NewRegisterMessageContent' => 'HTMLText',
        'EmailsActive' => 'Boolean',
        'EventAdminEmail' => 'Varchar(255)',
        "MaxGroupSize" => "Int",
        "SocialTikTok" => "Varchar(255)",
        "SocialInstagram" => "Varchar(255)",
        "SocialFacebook" => "Varchar(255)",
        "SocialLinkedIn" => "Varchar(255)",
        "SocialYoutube" => "Varchar(255)",
    ];

    private static $defaults = [
        'EmailsActive' => true,
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab("Root.Main", TextField::create("DateText", "Date Text"));
        $fields->addFieldToTab("Root.Main", TextField::create("PlaceText", "Place Text"));
        $fields->addFieldToTab("Root.Main", CheckboxField::create("ShowBanner", "Show Banner"));
        $fields->addFieldToTab("Root.Main", TextField::create("BannerText", "Banner Text"));
        $fields->addFieldToTab("Root.Main", TextField::create("MaxGroupSize", "Maximale Gruppengröße zum registrieren"));
        $fields->addFieldToTab('Root.Event Emails', CheckboxField::create('EmailsActive', 'E-Mails aktiviert'));
        $fields->addFieldToTab('Root.Event Emails', TextField::create('EventAdminEmail', 'Event Admin Emailadresse'));
        $fields->addFieldToTab('Root.Event Emails', TextField::create('AckMessageSubject', 'Empfangsbestätigung Betreff'));
        $fields->addFieldToTab('Root.Event Emails', HTMLEditorField::create('AckMessageContent', 'Empfangsbestätigung Inhalt'));
        $fields->addFieldToTab('Root.Event Emails', TextField::create('TicketMessageSubject', 'Ticket-Email Betreff'));
        $fields->addFieldToTab('Root.Event Emails', HTMLEditorField::create('TicketMessageContent', 'Ticket-Email Inhalt'));
        $fields->addFieldToTab('Root.Event Emails', TextField::create('NewRegisterMessageSubject', 'Neue Anmeldung Betreff'));
        $fields->addFieldToTab('Root.Event Emails', HTMLEditorField::create('NewRegisterMessageContent', 'Neue Anmeldung Inhalt'));
        $fields->addFieldToTab('Root.Social Media', TextField::create('SocialTikTok', 'TikTok'));
        $fields->addFieldToTab('Root.Social Media', TextField::create('SocialInstagram', 'Instagram'));
        $fields->addFieldToTab('Root.Social Media', TextField::create('SocialFacebook', 'Facebook'));
        $fields->addFieldToTab('Root.Social Media', TextField::create('SocialLinkedIn', 'LinkedIn'));
        $fields->addFieldToTab('Root.Social Media', TextField::create('SocialYoutube', 'YouTube'));

    }

    public function getMaxGroupSizeAsArraySize()
    {
        //Create an array in the size of MaxGroupSize
        $sizes = [];
        for ($i = 1; $i <= $this->owner->MaxGroupSize; $i++) {
            $sizes[] = $i;
        }
        return $sizes;
    }
}
