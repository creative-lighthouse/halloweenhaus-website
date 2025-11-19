<?php

namespace App\Shows;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

/**
 * Class \App\Shows\Artefact
 *
 * @property ?string $Title
 * @property ?string $Jointime
 * @property ?string $Description
 * @property ?string $ShortDescription
 * @property int $SortField
 * @property int $ImageID
 * @method Image Image()
 * @method DataList<ArtefactOwnership> ArtefactOwnerships()
 * @method ManyManyList<Show> Shows()
 * @mixin FileLinkTracking
 * @mixin AssetControlExtension
 * @mixin SiteTreeLinkTracking
 * @mixin RecursivePublishable
 * @mixin VersionedStateExtension
 */
class Artefact extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Jointime" => "Varchar(255)",
        "Description" => "HTMLText",
        "ShortDescription" => "Varchar(50)",
        "SortField" => "Int",
    ];

    private static $many_many = [
        "Shows" => Show::class,
    ];

    private static $has_one = [
        "Image" => Image::class,
    ];

    private static $has_many = [
        "ArtefactOwnerships" => ArtefactOwnership::class,
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

    private static $table_name = "Artefacts";

    private static $singular_name = "Artefakt";
    private static $plural_name = "Artefakte";

    private static $url_segment = "artefact";

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
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/artefact/{$this->ID}/edit");
    }

    public function getLink ()
    {
        $showOverviewPage = ShowOverviewPage::get()->first();
        if($showOverviewPage)
        {
            return $showOverviewPage->Link("artefact/{$this->ID}");
        } else {
            return "";
        }
    }
}
