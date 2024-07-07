<?php

namespace App\Events;

use IntlDateFormatter;
use App\Events\EventAdmin;
use App\Events\Registration;
use App\Events\EventTimeSlot;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use Colymba\BulkManager\BulkManager;
use SilverStripe\Forms\GridField\GridField;

/**
 * Class \App\Team\TeamMember
 *
 * @property string $Title
 * @property string $Place
 * @property string $EventDate
 * @property string $StartTime
 * @property string $EndTime
 * @property string $Description
 * @property string $InfoForAttendees
 * @property int $SlotDuration
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image Image()
 * @method \SilverStripe\ORM\DataList|\App\Events\EventTimeSlot[] TimeSlots()
 */
class Event extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Place" => "Varchar(255)",
        "EventDate" => "Date",
        "StartTime" => "Time",
        "EndTime" => "Time",
        "Description" => "HTMLText",
        "InfoForAttendees" => "HTMLText",
        "SlotDuration" => "Int",
    ];

    private static $has_one = [
        "Image" => Image::class,
    ];

    private static $has_many = [
        "TimeSlots" => EventTimeSlot::class,
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
        "Image" => "Bild",
        "SlotDuration" => "Dauer eines Slots (in Minuten)",
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

    public function getDateFormatted()
    {
        return date("d.m.y", strtotime($this->EventDate));
    }

    public function getDateWeekday()
    {
        $fmt = new IntlDateFormatter('de', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, "ccc");
        $timestamp = strtotime($this->EventDate);

        return $fmt->format($timestamp);
    }

    public function getDateDay()
    {
        $fmt = new IntlDateFormatter('de', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, "d");
        $timestamp = strtotime($this->EventDate);

        return $fmt->format($timestamp);
    }

    public function getDateMonthTitle()
    {
        $fmt = new IntlDateFormatter('de', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, "MMM");
        $timestamp = strtotime($this->EventDate);

        return $fmt->format($timestamp);
    }

    public function FreeTimeSlots()
    {
        $timeslots = $this->TimeSlots();
        $timeslotsWithSpace = new ArrayList();
        foreach ($timeslots as $timeslot) {
            if ($timeslot->getFreeSlotCount() > 0) {
                $timeslotsWithSpace->push($timeslot);
            }
        }
        return $timeslotsWithSpace;
    }

    public function FullTimeSlots()
    {
        $timeslots = $this->TimeSlots();
        $timeslotsWithoutSpace = new ArrayList();
        foreach ($timeslots as $timeslot) {
            if ($timeslot->getFreeSlotCount() <= 0) {
                $timeslotsWithoutSpace->push($timeslot);
            }
        }
        return $timeslotsWithoutSpace;
    }
}
