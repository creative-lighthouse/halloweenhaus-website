<?php

namespace App\Shows;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;

class Character extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Place" => "Varchar(255)",
        "Jointime" => "Varchar(255)",
        "Bodysize" => "Varchar(255)",
        "Bodyweight" => "Varchar(255)",
        "Age" => "Varchar(255)",
        "Description" => "HTMLText",
        "SortField" => "Int",
        "Type" => "Varchar(255)",
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
        "Place" => "Herkunft",
        "Jointime" => "Erster Auftritt",
        "Bodysize" => "Körpergröße",
        "Bodyweight" => "Körpergewicht",
        "Age" => "Alter",
        "Description" => "Beschreibung",
        "Image" => "Bild",
        "Type" => "Typ",
    ];

    private static $summary_fields = [
        "Title" => "Name",
        "Place" => "Herkunft",
        "Jointime" => "Erster Auftritt",
    ];

    private static $searchable_fields = [
        "Title",
        "Description",
    ];

    private static $table_name = "Characters";

    private static $singular_name = "Charakter";
    private static $plural_name = "Charaktere";

    private static $url_segment = "character";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', DropdownField::create('Type', 'Typ', [
            'humanplayed' => 'Von Schauspieler gespielt',
            'animatronic' => 'Animatronik',
            'other' => 'Sonstiges'
        ]), 'Description');
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = ShowAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }
}
