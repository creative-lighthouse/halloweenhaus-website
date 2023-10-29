<?php

namespace App\Events;

use App\Events\EventAdmin;
use App\Events\Registration;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\LinkField\Form\LinkField;
use SilverStripe\ORM\FieldType\DBDatetime;

/**
 * Class \App\Team\TeamMember
 *
 * @property string $Title
 * @property string $ShortDescription
 * @property string $Place
 * @property string $StartTime
 * @property string $EndTime
 * @property string $Description
 * @property int $MaxAttendees
 * @property string $InfoForAttendees
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image Image()
 */
class Event extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "ShortDescription" => "HTMLText",
        "Place" => "Varchar(255)",
        "StartTime" => DBDatetime::class,
        "EndTime" => DBDatetime::class,
        "Description" => "HTMLText",
        "MaxAttendees" => "Int",
        "InfoForAttendees" => "HTMLText",
    ];

    private static $has_one = [
        "Image" => Image::class,
    ];

    private static $owns = [
        "Image"
    ];

    private static $belongs_many = [
        "Registrations" => Registration::class,
    ];

    private static $default_sort = "StartTime ASC";

    private static $field_labels = [
        "Title" => "Name",
        "Place" => "Ort",
        "StartTime" => "Startzeit",
        "EndTime" => "Endzeit",
        "Description" => "Beschreibung",
        "MaxAttendees" => "Maximale Teilnehmerzahl",
        "InfoForAttendees" => "Informationen für Teilnehmer",
    ];

    private static $summary_fields = [
        "Title" => "Name",
        "StartTime" => "Startzeit",
        "RegistrationsFormatted" => "Anmeldungen",
    ];

    private static $searchable_fields = [
        "Title", "Description",
    ];

    private static $table_name = "Event";

    private static $singular_name = "Event";
    private static $plural_name = "Events";

    private static $url_segment = "event";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = EventAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }

    function InFuture()
    {
        return $this->dbObject("StartDate")->InFuture();
    }

    function getRegistrationsFormatted()
    {
        if ($this->MaxAttendees) {
            $registrations = Registration::get()->filter("EventID", $this->ID);
            return sprintf("%d / %d", $registrations->Count(), $this->MaxAttendees) . " Anmeldungen";
        } else {
            return $this->getRegistrations()->Count() . " Anmeldungen";
        }
    }

    function getRegistrations()
    {
        $registrations = Registration::get()->filter("EventID", $this->ID);
        return $registrations;
    }

    function getRemainingSeats()
    {
        $registrations = Registration::get()->filter("EventID", $this->ID);
        if ($this->MaxAttendees) {
            return $this->MaxAttendees - $registrations->Count();
        } else {
            return 0;
        }
    }

    public function getRegistrationLink()
    {
        $holderNew = EventPage::get()->sort("ID", "ASC")->First();
        if ($holderNew) {
            return $holderNew->AbsoluteLink("register/") . $this->ID;
        }
        return "/404";
    }

    public function getLink()
    {
        $holderNew = EventPage::get()->sort("ID", "ASC")->First();
        if ($holderNew) {
            return $holderNew->AbsoluteLink("view/") . $this->ID;
        }
        return "/404";
    }
}
