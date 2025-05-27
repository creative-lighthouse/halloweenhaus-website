<?php

namespace App\Events;

use Page;

/**
 * Class \App\Events\EventAdminPage
 *
 */
class EventAdminPage extends Page
{
    private static $table_name = 'EventAdminPage';

    private static $icon = "app/client/icons/events_admin.svg";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
