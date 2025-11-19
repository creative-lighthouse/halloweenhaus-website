<?php

namespace App\Shows;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;

/**
 * Class \App\Shows\Location
 *
 * @property ?string $Title
 * @property ?string $Jointime
 * @property ?string $Description
 * @property int $SortField
 * @property ?string $ShortDescription
 * @property int $ImageID
 * @method Image Image()
 * @method ManyManyList<Show> Shows()
 * @mixin FileLinkTracking
 * @mixin AssetControlExtension
 * @mixin SiteTreeLinkTracking
 * @mixin RecursivePublishable
 * @mixin VersionedStateExtension
 */
class Location extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Jointime" => "Varchar(255)",
        "Description" => "HTMLText",
        "SortField" => "Int",
        "ShortDescription" => "Varchar(50)",
    ];

    private static $many_many = [
        "Shows" => Show::class,
    ];

    private static $has_one = [
        "Image" => Image::class,
    ];

    private static $owns = [
        "Image"
    ];

    private static $default_sort = "SortField ASC";

    private static $field_labels = [
        "Title" => "Name",
        "Jointime" => "Erstes Vorkommen",
        "Description" => "Beschreibung",
        "Image" => "Bild",
        "ShortDescription" => "Kurze Beschreibung (Max 50 Zeichen)",
    ];

    private static $summary_fields = [
        "Title" => "Name",
        "Jointime" => "Erstes Vorkommen",
    ];

    private static $searchable_fields = [
        "Title",
        "Jointime",
    ];

    private static $table_name = "Locations";

    private static $singular_name = "Ort";
    private static $plural_name = "Orte";

    private static $url_segment = "location";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("SortField");
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = ShowAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/location/{$this->ID}/edit");
    }

    public function getLink ()
    {
        $showOverviewPage = ShowOverviewPage::get()->first();
        if($showOverviewPage)
        {
            return $showOverviewPage->Link("location/{$this->ID}");
        } else {
            return "";
        }
    }
}
