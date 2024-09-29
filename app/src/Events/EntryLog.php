<?php

namespace App\Events;

use SilverStripe\ORM\DataObject;

class EntryLog extends DataObject
{
    private static $db = [
        "EntryTime" => "Datetime",
        "SQ" => "Int",
        "VQ" => "Int",
    ];

    private static $default_sort = "EntryTime ASC";

    private static $field_labels = [
        "EntryTime" => "Eintrittszeit",
        "SQ" => "Standby Queue Gäste",
        "VQ" => "Virtual Queue Gäste",
    ];

    private static $summary_fields = [
        "EntryTime" => "Eintrittszeit",
        "SQ" => "Standby Queue Gäste",
        "VQ" => "Virtual Queue Gäste",
        "TotalGuests" => "Gesamtanzahl",
    ];

    private static $table_name = "EntryLog";

    private static $singular_name = "Eintrittslog";
    private static $plural_name = "Eintrittslogs";

    private static $url_segment = "entrylog";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }

    public function getTotalGuests()
    {
        return $this->SQ + $this->VQ;
    }
}
