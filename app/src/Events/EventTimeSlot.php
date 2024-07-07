<?php

namespace App\Events;

use App\Events\EventAdmin;
use App\Events\Registration;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBTime;
use SilverStripe\ORM\FieldType\DBDatetime;

/**
 * Class \App\Team\TeamMember
 *
 * @property string $SlotTime
 * @property int $MaxAttendees
 * @property int $MaxVIPs
 * @property int $ParentID
 * @method \App\Events\Event Parent()
 */
class EventTimeSlot extends DataObject
{
    private static $db = [
        "SlotTime" => "Time",
        "MaxAttendees" => "Int",
        "MaxVIPs" => "Int",
    ];

    private static $has_one = [
        "Parent" => Event::class,
    ];

    private static $belongs_many = [
        "Registrations" => Registration::class,
    ];

    private static $default_sort = "SlotTime ASC";

    private static $field_labels = [
        "SlotTime" => "Startzeit",
        "MaxAttendees" => "Maximale Anzahl an Teilnehmern",
        "MaxVIPs" => "Maximale Anzahl an VIPs",
    ];

    private static $summary_fields = [
        "SlotTime" => "Startzeit",
        "AttendeesFormatted" => "Teilnehmer",
    ];

    private static $searchable_fields = [
        "SlotTime",
        "MaxAttendees",
    ];

    private static $table_name = "EventTimeSlot";

    private static $singular_name = "Zeit-Slot";
    private static $plural_name = "Zeit-Slots";

    private static $url_segment = "timeslot";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("ParentID");
        return $fields;
    }

    public function getRegistrationsCount()
    {
        $allRegistrations = Registration::get()->filter(["TimeSlotID" => $this->ID]);
        $registrationCount = 0;
        foreach ($allRegistrations as $registration) {
            if ($registration->Event()->ID == $this->ParentID) {
                $registrationCount += $registration->GroupSize;
            }
        }
        return $registrationCount;
    }

    public function AttendeesFormatted()
    {
        return $this->MaxAttendees - $this->getRegistrationsCount() . " Plätze frei";
    }

    public function getFreeSlotCount()
    {
        return $this->MaxAttendees - $this->getRegistrationsCount();
    }

    public function getSlotTimeFormatted()
    {
        return date("H:i", strtotime($this->SlotTime));
    }

    public function getSlotTimeEndFormatted()
    {
        $slotDuration = $this->Parent()->SlotDuration;
        $slotTime = strtotime($this->SlotTime);
        $slotTimeEnd = $slotTime + $slotDuration * 60;
        return date("H:i", $slotTimeEnd);
    }
}
