<?php

namespace App\Shows;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

/**
 * Class \App\Shows\Artefact
 *
 * @property ?string $StartTime
 * @property ?string $EndTime
 * @property ?string $Description
 * @property int $ParentID
 * @property int $OwnerID
 * @method Artefact Parent()
 * @method Character Owner()
 * @mixin FileLinkTracking
 * @mixin AssetControlExtension
 * @mixin SiteTreeLinkTracking
 * @mixin RecursivePublishable
 * @mixin VersionedStateExtension
 */
class ArtefactOwnership extends DataObject
{
    private static $db = [
        "StartTime" => "Varchar(255)",
        "EndTime" => "Varchar(255)",
        "Description" => "HTMLText",
    ];

    private static $has_one = [
        "Parent" => Artefact::class,
        "Owner" => Character::class,
    ];

    private static $default_sort = "ArtefactID ASC";

    private static $field_labels = [
        "Owner" => "Besitzer",
        "Artefact" => "Artefakt",
        "StartTime" => "Besitz von",
        "EndTime" => "Besitz bis",
        "Description" => "Beschreibung",
    ];

    private static $summary_fields = [
        "Owner" => "Besitzer",
        "Artefact" => "Artefakt",
        "RenderOwnershipTimespan" => "Besitzzeitraum",
    ];

    private static $searchable_fields = [
        "Owner",
        "Artefact",
    ];

    private static $table_name = "ArtefactOwnerships";

    private static $singular_name = "Artefaktbesitzer";
    private static $plural_name = "Artefaktbesitzer";

    private static $url_segment = "artefactownership";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = ShowAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/artefactownership/{$this->ID}/edit");
    }

    public function RenderOwnershipTimespan()
    {
        $start = $this->StartTime ? $this->StartTime : "Unbekannt";
        $end = $this->EndTime ? $this->EndTime : "Heute";
        return "{$start} - {$end}";
    }
}
