<?php

namespace App\Shows;

use App\Shows\ShowAdmin;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Model\List\GroupedList;

class Show extends DataObject
{
    private static $db = [
        "Year" => "Int",
        "Title" => "Varchar(255)",
        "Place" => "Varchar(255)",
        "Storyline" => "HTMLText",
        "WalkthroughLink" => "Varchar(255)",
        "GuestCount" => "Int",
        "DaysOpen" => "Int",
        "WalkingLength" => "Int",
        "ShowLength" => "Int",
        "TeamSize" => "Int",
        "SceneCount" => "Int",
    ];

    private static $has_one = [
        "PosterImage" => Image::class,
        "ShowImage" => Image::class,
    ];

    private static $has_many = [
        "ShowCharacters" => ShowCharacter::class,
    ];

    private static $owns = [
        "PosterImage",
        "ShowImage",
        "ShowCharacters",
    ];

    private static $default_sort = "Year ASC";

    private static $field_labels = [
        "Year" => "Jahr",
        "Title" => "Titel",
        "Place" => "Ort",
        "Storyline" => "Handlung",
        "PosterImage" => "Poster Bild",
        "ShowImage" => "Show Bild",
        "WalkthroughLink" => "Walkthrough Video-Link (Youtube)",
        "GuestCount" => "Gästeanzahl",
        "DaysOpen" => "Tage geöffnet",
        "WalkingLength" => "Laufstrecke (in Metern)",
        "ShowLength" => "Showlänge (in Minuten)",
        "TeamSize" => "Teamgröße",
        "SceneCount" => "Anzahl der Szenen",
        "ShowCharacters" => "Charaktere",
    ];

    private static $summary_fields = [
        "Year" => "Jahr",
        "Title" => "Titel",
        "Place" => "Ort",
    ];

    private static $searchable_fields = [
        "Year",
        "Title",
        "Place",
    ];

    private static $table_name = "Show";

    private static $singular_name = "Show";
    private static $plural_name = "Shows";

    private static $url_segment = "show";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        //Media Tab
        $fields->findOrMakeTab('Root.Media', 'Medien');
        $fields->addFieldToTab('Root.Media', $fields->dataFieldByName('PosterImage'));
        $fields->addFieldToTab('Root.Media', $fields->dataFieldByName('ShowImage'));
        $fields->addFieldToTab('Root.Media', $fields->dataFieldByName('WalkthroughLink'));

        //Statistics Tab
        $fields->findOrMakeTab('Root.Statistics', 'Statistiken');
        $fields->addFieldToTab('Root.Statistics', $fields->dataFieldByName('GuestCount'));
        $fields->addFieldToTab('Root.Statistics', $fields->dataFieldByName('DaysOpen'));
        $fields->addFieldToTab('Root.Statistics', $fields->dataFieldByName('WalkingLength'));
        $fields->addFieldToTab('Root.Statistics', $fields->dataFieldByName('ShowLength'));
        $fields->addFieldToTab('Root.Statistics', $fields->dataFieldByName('TeamSize'));
        $fields->addFieldToTab('Root.Statistics', $fields->dataFieldByName('SceneCount'));
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = ShowAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }

    public function getGroupedCharacters()
    {
        //Group the Characters because a character can be played by multiple TeamMembers
        $groupedCharacters = GroupedList::create($this->ShowCharacters())->groupBy('CharacterID');
        return $groupedCharacters;
    }
}
