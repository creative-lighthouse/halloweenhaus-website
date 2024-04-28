<?php
namespace App\Events;

use App\Events\Event;
use App\Events\Registration;
use App\Events\EmailNotification;
use SilverStripe\Admin\ModelAdmin;
use Colymba\BulkManager\BulkManager;
use SilverStripe\Forms\GridField\GridFieldConfig;

/**
 * Class \App\Team\TeamAdmin
 *
 */
class EventAdmin extends ModelAdmin
{
    private static $managed_models = array (
        Event::class,
        Registration::class,
        EmailNotification::class,
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

        $config->addComponent(new BulkManager(), 'GridFieldEditButton');

        return $config;
    }
}
