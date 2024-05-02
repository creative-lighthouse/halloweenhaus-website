<?php

namespace App\Events;

use Page;
use SilverStripe\Assets\Image;

use SilverStripe\AssetAdmin\Forms\UploadField;

/**
 * Class \App\Team\TeamOverview
 *
 */
class EventAdminPage extends Page
{
    private static $table_name = 'EventAdminPage';

    private static $icon = "app/client/icons/date.svg";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
