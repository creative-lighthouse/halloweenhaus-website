<?php

namespace App\Statistics;

use Page;
use SilverStripe\ORM\DataObject;
use App\Statistics\PageStatistic;
use SilverStripe\Model\ArrayData;
use SilverStripe\Security\Security;
use SilverStripe\Model\List\ArrayList;
use App\Statistics\PageStatisticsAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\LiteralField;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;

class PageStatisticsDay extends DataObject
{
    private static $db = [
        "Date" => "Date"
    ];

    private static $has_many = [
        "Hours" => PageStatisticsHour::class
    ];

    private static $owns = [
        "Hours"
    ];

    private static $default_sort = "Date ASC";

    private static $field_labels = [
        "Date" => "Datum",
        "GuestViews" => "Seitenaufrufe",
        "Hours" => "Stunden"
    ];

    private static $summary_fields = [
        "RenderNiceDate" => "Datum",
        "getTotalGuestCountForDay" => "Gast-Aufrufe",
        "getTotalAdminCountForDay" => "Admin-Aufrufe",
        "getTotalViewCount" => "Gesamt-Aufrufe",
    ];


    private static $table_name = "PageStatisticsDay";

    private static $singular_name = "Tagesaufrufzahl";
    private static $plural_name = "Tagesaufrufzahlen";

    private static $url_segment = "pagestatisticsday";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("Hours");
        $fields->addFieldToTab(
            "Root.Main",
            GridField::create(
                "Hours",
                "Aufrufstunden",
                $this->Hours(),
                GridFieldConfig_RecordEditor::create()
            )
        );
        $viewsPerPage = $this->getViewsPerPageForThisDay();
        //Sort by most views
        arsort($viewsPerPage);

        $fields->addFieldToTab(
            "Root.Main",
            LiteralField::create(
                "ViewsPerPage",
                "<h3>Aufrufe pro Seite</h3>" .
                    "<ul>" .
                    implode(
                        "",
                        array_map(
                            function ($pageID) use ($viewsPerPage) {
                                $page = Page::get()->byID($pageID);
                                $title = $page ? $page->Title : "Unbekannte Seite (ID: $pageID)";
                                $count = $viewsPerPage[$pageID];
                                return "<li>$title: $count Aufrufe</li>";
                            },
                            array_keys($viewsPerPage)
                        )
                    ) .
                    "</ul>"

            )
        );
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = PageStatisticsAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }

    public function getTotalGuestCountForDay()
    {
        $total = 0;
        foreach ($this->Hours() as $hour) {
            $total += $hour->getTotalGuestViewCount();
        }
        return $total;
    }

    public function getTotalAdminCountForDay()
    {
        $total = 0;
        foreach ($this->Hours() as $hour) {
            $total += $hour->getTotalAdminViewCount();
        }
        return $total;
    }

    public function getTotalViewCount()
    {
        return $this->getTotalGuestCountForDay() + $this->getTotalAdminCountForDay();
    }

    public function getViewsPerPageForThisDay()
    {
        $views = [];
        foreach ($this->Hours() as $hour) {
            foreach ($hour->PageStatistics() as $pageStat) {
                $pageID = $pageStat->PageID;
                if (!isset($views[$pageID])) {
                    $views[$pageID] = 0;
                }
                $views[$pageID] += $pageStat->GuestViews + $pageStat->AdminViews;
            }
        }
        return $views;
    }

    public function RenderNiceDate()
    {
        return date("d.m.Y", strtotime($this->Date));
    }

    public static function incrementPageViewForPage($page)
    {
        if (!$page || !$page->ID) {
            return;
        }
        $pageID = $page->ID;
        $pageStat = PageStatistic::createIfNotExists($pageID);
        if (!$pageStat) {
            return;
        }

        //Check if user is logged in
        if (Security::getCurrentUser()) {
            $pageStat->AdminViews += 1;
        } else {
            $pageStat->GuestViews += 1;
        }
        $pageStat->write();
    }
}
