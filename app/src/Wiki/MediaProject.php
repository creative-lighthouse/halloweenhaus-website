<?php

namespace App\Wiki;

use SilverStripe\Assets\Image;
use App\Wiki\ArtefactOwnership;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Model\List\GroupedList;

/**
 * Class \App\Wiki\MediaProject
 *
 * @property ?string $Title
 * @property ?string $Place
 * @property ?string $Description
 * @property ?string $PublicationDate
 * @property int $SortField
 * @property int $ImageID
 * @method Image Image()
 * @mixin AssetControlExtension
 * @mixin FileLinkTracking
 * @mixin SiteTreeLinkTracking
 * @mixin RecursivePublishable
 * @mixin VersionedStateExtension
 */
class MediaProject extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Place" => "Varchar(255)",
        "Description" => "HTMLText",
        "PublicationDate" => "Date",
        "SortField" => "Int",
    ];

    private static $has_one = [
        "Image" => Image::class,
    ];

    private static $owns = [
        "Image"
    ];

    private static $default_sort = "PublicationDate DESC";

    private static $field_labels = [
        "Title" => "Titel",
        "Place" => "Veröffentlichungsort",
        "Description" => "Beschreibung",
        "PublicationDate" => "Veröffentlichungsdatum",
    ];

    private static $summary_fields = [
        "Title" => "Titel",
        "PublicationDate" => "Veröffentlichungsdatum",
    ];

    private static $searchable_fields = [
        "Title",
        "Place",
        "PublicationDate",
    ];

    private static $table_name = "MediaProjects";

    private static $singular_name = "Medienprojekt";
    private static $plural_name = "Medienprojekte";

    private static $url_segment = "mediaproject";

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
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/character/{$this->ID}/edit");
    }

    public function getLink ()
    {
        $wikiPage = WikiPage::get()->first();
        if($wikiPage)
        {
            return $wikiPage->Link("media/{$this->ID}");
        } else {
            return "";
        }
    }

    public function NextMediaProject()
    {
        return MediaProject::get()->filter('PublicationDate:GreaterThan', $this->PublicationDate)->sort('PublicationDate', 'ASC')->first();
    }

    public function PreviousMediaProject()
    {
        return MediaProject::get()->filter('PublicationDate:LessThan', $this->PublicationDate)->sort('PublicationDate', 'DESC')->first();
    }
}
