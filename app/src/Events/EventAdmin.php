<?php

namespace App\Events;

use App\Events\Event;
use App\Events\EventCoupon;
use App\Events\Registration;
use App\Events\EmailNotification;
use SilverStripe\Forms\FieldList;
use SilverStripe\Admin\ModelAdmin;
use Colymba\BulkManager\BulkManager;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\LiteralField;

/**
 * Class \App\Events\EventAdmin
 *
 */
class EventAdmin extends ModelAdmin
{
    private static $managed_models = array(
        Event::class,
        Registration::class,
        EmailNotification::class,
        EventCoupon::class,
        EntryLog::class,
    );

    private static $url_segment = "events";

    private static $menu_title = "Events";

    private static $menu_icon = "app/client/icons/events_admin.svg";

    public function init()
    {
        parent::init();
    }

    protected function getGridFieldConfig(): GridFieldConfig
    {
        $config = parent::getGridFieldConfig();

        $config->addComponent(BulkManager::create(), 'GridFieldEditButton');

        return $config;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $totalsqguestcount = EntryLog::get()->sum('SQ');
        $totalvqguestcount = EntryLog::get()->sum('VQ');
        $totalguestcount = $totalsqguestcount + $totalvqguestcount;

        $fields->addFieldToTab(
            'Root.Gästezähler',
            LiteralField::create('Total Guests', $totalvqguestcount + " | " + $totalsqguestcount + " | " + $totalguestcount)
        );
    }
}
