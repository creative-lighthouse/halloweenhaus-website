<?php
namespace App\Events;

use App\Events\Event;
use App\Events\Registration;
use App\Events\EmailNotification;
use SilverStripe\Admin\ModelAdmin;

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

    private static $menu_icon = "app/client/icons/date.svg";

    public function init()
    {
        parent::init();
    }
}
