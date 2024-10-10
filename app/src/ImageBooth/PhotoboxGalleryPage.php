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

    private static $icon = "app/client/icons/imagebooth_admin.svg";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
