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
 */
class CustomSiteConfig extends DataExtension
{

    private static $db = [
        'DateText' => 'Varchar(255)',
        "PlaceText" => "Varchar(255)",
        "ShowBanner" => "Boolean",
        "BannerText" => "HTMLText",
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab("Root.Main", new TextField("DateText", "Date Text"));
        $fields->addFieldToTab("Root.Main", new TextField("PlaceText", "Place Text"));
        $fields->addFieldToTab("Root.Main", new CheckboxField("ShowBanner", "Show Banner"));
        $fields->addFieldToTab("Root.Main", new HTMLEditorField("BannerText", "Banner Text"));
    }
}
