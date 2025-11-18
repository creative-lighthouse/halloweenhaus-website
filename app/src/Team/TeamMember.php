<?php

namespace App\Team;

use App\Team\TeamAdmin;
use App\Team\TeamSocial;
use App\Shows\ShowCharacter;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Forms\DropdownField;

/**
 * Class \App\Team\TeamMember
 *
 * @property string $Title
 * @property string $Profession
 * @property string $Jointime
 * @property string $Description
 * @property string $Status
 * @property int $ImageID
 * @method Image Image()
 * @method DataList|PhotoGalleryImage[] PhotoGalleryImages()
 * @method ManyManyList|TeamSocial[] Socials()
 * @mixin PhotoGalleryExtension
 */
class TeamMember extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Profession" => "Varchar(255)",
        "Jointime" => "Varchar(255)",
        "Description" => "HTMLText",
        "SortField" => "Int",
        "Status" => "Varchar(255)"
    ];

    private static $has_one = [
        "Image" => Image::class,
    ];

    private static $owns = [
        "Image"
    ];

    private static $many_many = [
        "Socials" => TeamSocial::class
    ];

    private static $belongs_many = [
        "ShowCharacters" => ShowCharacter::class
    ];

    private static $default_sort = "Status, SortField ASC";

    private static $field_labels = [
        "Title" => "Name",
        "Profession" => "Aufgabenbereich",
        "Jointime" => "Dabei seit",
        "Description" => "Beschreibung",
        "Socials" => "Soziale Links",
        "Status" => "Status",
    ];

    private static $summary_fields = [
        "Thumbnail" => "Bild",
        "Title" => "Name",
        "Profession" => "Aufgabenbereich",
        "RenderStatus" => "Status"
    ];

    private static $searchable_fields = [
        "Title",
        "Description",
    ];

    private static $table_name = "TeamMembers";

    private static $singular_name = "Team-Mitglied";
    private static $plural_name = "Team-Mitglieder";

    private static $url_segment = "teammember";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->replaceField('Status', DropdownField::create('Status', 'Status', [
            "active" => "Aktiv",
            "formerly" => "Ehemalig",
            "hidden" => "Versteckt",
        ]));
        $fields->removeByName("SortField");
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = TeamAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }

    public function getFormattedName()
    {
        return str_replace(' ', '_', $this->Title);
    }

    public function getThumbnail()
    {
        $file = $this->Image();
        if ($file) {
            return $file->Fit(100, 100);
        }
        return null;
    }

    public function RenderStatus()
    {
        switch ($this->Status) {
            case 'active':
                return 'Aktiv';
            case 'formerly':
                return 'Ehemalig';
            case 'hidden':
                return 'Versteckt';
            default:
                return $this->Status;
        }
    }

    public function getRoles()
    {
        return ShowCharacter::get()->filter('TeamMemberID', $this->ID);
    }
}
