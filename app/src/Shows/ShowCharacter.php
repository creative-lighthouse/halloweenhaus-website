<?php

namespace App\Shows;

use App\Shows\Show;
use App\Shows\Character;
use App\Team\TeamMember;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

/**
 * Class \App\Team\Character
 *
 * @property string $Title
 * @property string $Place
 * @property string $Jointime
 * @property string $Bodysize
 * @property string $Age
 * @property string $Description
 * @property int $Importance
 * @property bool $InCarousel
 * @property int $ImageID
 * @method Image Image()
 */
class ShowCharacter extends DataObject
{
    private static $db = [
        "Note" => "Varchar(255)",
    ];

    private static $has_one = [
        "Parent" => Show::class,
        "Character" => Character::class,
        "TeamMember" => TeamMember::class,
    ];

    private static $default_sort = "CharacterID ASC";

    private static $field_labels = [
        "Note" => "Notiz",
        "Character" => "Charakter",
        "TeamMember" => "Teammitglied",
    ];

    private static $summary_fields = [
        "Character.Title" => "Charakter",
        "TeamMember.Title" => "Teammitglied",
        "Note" => "Notiz",
    ];

    private static $searchable_fields = [
        "Character.Title",
        "TeamMember.Title",
        "Note",
    ];

    private static $table_name = "ShowCharacter";

    private static $singular_name = "Show Charakter";
    private static $plural_name = "Show Charaktere";

    private static $url_segment = "showcharacter";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ParentID');
        //Move Notes to the bottom
        $noteField = $fields->dataFieldByName('Note');
        $fields->removeByName('Note');
        $fields->addFieldToTab('Root.Main', $noteField);
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = ShowAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }

    public function RenderRole()
    {
        if($this->Character)
        {
            return $this->Character->Title;
        } else {
            return "Nebenrolle";
        }
    }

    public function RenderTeamMemberName()
    {
        if($this->TeamMember)
        {
            return $this->TeamMember->Title;
        } else {
            if($this->Character)
            {
                if($this->Character->Type == 'humanplayed')
                {
                    return $this->Character->Title . " (Unbekannter Schauspieler)";
                } elseif($this->Character->Type == 'animatronic'){
                    return $this->Character->Title . " (Animatronik)";
                } else {
                    return $this->Character->Title . " (Keine Schauspielerrolle)";
                }
            } else {
                return "Unbekannter Schauspieler";
            }
        }
    }
}
