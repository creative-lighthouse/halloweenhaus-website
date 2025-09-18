<?php

namespace App\Statistics;

use Page;
use SilverStripe\ORM\DataObject;

class PageStatistic extends DataObject
{
    private static $db = [
        "GuestViews" => "Int",
        "AdminViews" => "Int",
    ];

    private static $has_one = [
        "Parent" => PageStatisticsHour::class,
        "Page" => Page::class
    ];

    private static $default_sort = "PageViews DESC";

    private static $field_labels = [
        "Page.Title" => "Seite",
        "GuestViews" => "Gast-Aufrufe",
        "AdminViews" => "Admin-Aufrufe",
    ];

    private static $summary_fields = [
        "Page.Title" => "Seite",
        "GuestViews" => "Gast-Aufrufe",
        "AdminViews" => "Admin-Aufrufe",
        "getTotalViewCount" => "Gesamt-Aufrufe",
    ];

    private static $table_name = "PageStatistic";

    private static $singular_name = "Seitenstatistik";
    private static $plural_name = "Seitenstatistiken";

    private static $url_segment = "pagestatistics";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("ParentID");
        return $fields;
    }

    public function getTotalViewCount()
    {
        return $this->GuestViews + $this->AdminViews;
    }

    public static function createIfNotExists($pageID)
    {
        $currentDay = date('Y-m-d');
        $today = PageStatisticsDay::get()->filter('Date', $currentDay)->first();
        if (!$today) {
            $today = PageStatisticsDay::create();
            $today->Date = $currentDay;
            $today->write();
        }
        $currentHour = date('H:00:00');
        $hour = PageStatisticsHour::get()->filter('Time', $currentHour)->filter('ParentID', $today->ID)->first();
        if (!$hour) {
            $hour = PageStatisticsHour::create();
            $hour->Time = $currentHour;
            $hour->ParentID = $today->ID;
            $hour->write();
        }
        // Now check if there is already a pagestatistic for this page in this hour
        $pageStat = PageStatistic::get()->filter('PageID', $pageID)->filter('ParentID', $hour->ID)->first();
        if (!$pageStat) {
            $pageStat = PageStatistic::create();
            $pageStat->PageID = $pageID;
            $pageStat->ParentID = $hour->ID;
            $pageStat->GuestViews = 0;
            $pageStat->AdminViews = 0;
            $pageStat->write();
        }
        return $pageStat;
    }
}
