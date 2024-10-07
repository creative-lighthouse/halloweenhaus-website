<?php

namespace App\ImageBooth;

use Page;

/**
 * Class \App\Team\TeamOverview
 *
 */
class PhotoboxGalleryPage extends Page
{
    private static $table_name = 'PhotoboxGalleryPage';

    private static $icon = "app/client/icons/events_admin.svg";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
