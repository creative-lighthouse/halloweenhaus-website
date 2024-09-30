<?php

namespace App\Events;

use SilverStripe\ORM\DataObject;

/**
 * Class \App\Events\EntryLog
 *
 * @property string $EntryTime
 * @property int $SQ
 * @property int $VQ
 */
class EntryLog extends DataObject
{
    private static $db = [
        "EntryTime" => "Datetime",
        "SQ" => "Int",
        "VQ" => "Int",
    ];

    private static $default_sort = "EntryTime DESC";

    private static $field_labels = [
        "EntryTime" => "Eintrittszeit",
        "VQ" => "Virtual Queue Gäste",
        "SQ" => "Standby Queue Gäste",
    ];

    private static $summary_fields = [
        "EntryTime" => "Eintrittszeit",
        "VQ" => "Virtual Queue Gäste",
        "SQ" => "Standby Queue Gäste",
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
