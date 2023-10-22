<?php
namespace App\Events;

use App\Events\Event;
use App\Team\Character;
use App\Team\TeamMember;
use App\Events\Registration;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

/**
 * Class \App\Team\TeamAdmin
 *
 */
class EventAdmin extends ModelAdmin
{
    private static $managed_models = array (
        Event::class,
        Registration::class,
    );

    private static $url_segment = "events";

    private static $menu_title = "Events";

    private static $menu_icon = "app/client/icons/date.svg";

    public function init()
    {
        parent::init();
    }
}
