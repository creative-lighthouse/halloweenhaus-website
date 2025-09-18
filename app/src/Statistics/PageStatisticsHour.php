<?php

namespace App\Statistics;

use Page;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class PageStatisticsHour extends DataObject
{
    private static $db = [
        "Time" => "Time",
    ];

    private static $has_one = [
        "Parent" => PageStatisticsDay::class,
    ];

    private static $has_many = [
        "PageStatistics" => PageStatistic::class,
    ];

    private static $owns = [
        "PageStatistics"
    ];

    private static $default_sort = "Time ASC";

    private static $field_labels = [
        "Time" => "Uhrzeit",
    ];

    private static $summary_fields = [
        "Time" => "Uhrzeit",
        "getTotalGuestViewCount" => "Gast-Aufrufe",
        "getTotalAdminViewCount" => "Admin-Aufrufe",
        "getTotalViewCount" => "Gesamt-Aufrufe",
    ];

    private static $table_name = "PageStatisticsHour";

    private static $singular_name = "Stundenaufrufzahl";
    private static $plural_name = "Stundenaufrufzahlen";

    private static $url_segment = "pagestatisticshour";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("ParentID");
        $fields->removeByName("PageStatistics");
        $fields->addFieldToTab(
            "Root.Main",
            GridField::create(
                "PageStatistics",
                "Aufrufstunden",
                $this->PageStatistics(),
                GridFieldConfig_RecordEditor::create()
            )
        );
        return $fields;
    }

    public function getTotalGuestViewCount()
    {
        return $this->PageStatistics()->sum("GuestViews");
    }

    public function getTotalAdminViewCount()
    {
        return $this->PageStatistics()->sum("AdminViews");
    }

    public function getTotalViewCount()
    {
        return $this->getTotalGuestViewCount() + $this->getTotalAdminViewCount();
    }
}
