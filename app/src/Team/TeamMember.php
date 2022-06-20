<?php

namespace App\Team;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

/**
 * Class \App\Team\TeamMember
 *
 * @property string $Title
 * @property string $Profession
 * @property string $Jointime
 * @property string $Description
 * @property int $Importance
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image Image()
 * @method \SilverStripe\ORM\ManyManyList|\App\Team\TeamSocial[] Socials()
 */
class TeamMember extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Profession" => "Varchar(255)",
        "Jointime" => "Varchar(255)",
        "Description" => "HTMLText",
        "Importance" => "Int"
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

    private static $default_sort = "Importance DESC";

    private static $field_labels = [
        "Title" => "Name",
        "Profession" => "Aufgabenbereich",
        "Jointime" => "Seit wann dabei",
        "Description" => "Beschreibung",
        "Socials" => "Soziale Links",
        "Importance" => "Wichtigkeit"
    ];

    private static $summary_fields = [
        "Importance" => "Wichtigkeit",
        "Title" => "Name",
        "Profession" => "Aufgabenbereich",
    ];

    private static $searchable_fields = [
        "Title", "Description",
    ];

    private static $indexes = [
        'SortOrder' => true,
    ];

    private static $table_name = "TeamMembers";

    private static $singular_name = "Team-Mitglied";
    private static $plural_name = "Team-Mitglieder";

    private static $url_segment = "teammember";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = TeamAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }
}
