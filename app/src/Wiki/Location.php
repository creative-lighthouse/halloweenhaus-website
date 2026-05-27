<?php

namespace App\Wiki;

use App\Wiki\WikiPage;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

/**
 * Class \App\Wiki\Location
 *
 * @property ?string $Title
 * @property ?string $Jointime
 * @property ?string $Description
 * @property int $SortField
 * @property ?string $ShortDescription
 * @property int $ImageID
 * @method Image Image()
 * @method DataList<PhotoGalleryImage> PhotoGalleryImages()
 * @method ManyManyList<Show> Shows()
 * @method ManyManyList<MediaProject> MediaProjects()
 * @mixin PhotoGalleryExtension
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
        "MediaProjects" => MediaProject::class,
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
        "Image" => "Haupt-Bild",
        "ShortDescription" => "Kurze Beschreibung (Max 50 Zeichen)",
        "Images" => "Ortsbilder",
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
        $admin = WikiAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/location/{$this->ID}/edit");
    }

    public function getLink ()
    {
        $wikiPage = WikiPage::get()->first();
        if($wikiPage)
        {
            return $wikiPage->Link("location/{$this->ID}");
        } else {
            return "";
        }
    }

    public function getLocationShows()
    {
        return $this->Shows()->sort('Year', 'ASC');
    }

    public function NextLocation()
    {
        return Location::get()->filter('SortField:GreaterThan', $this->SortField)->sort('SortField', 'ASC')->first();
    }

    public function PreviousLocation()
    {
        return Location::get()->filter('SortField:LessThan', $this->SortField)->sort('SortField', 'DESC')->first();
    }
}
