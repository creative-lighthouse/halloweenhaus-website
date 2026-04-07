<?php

namespace App\ImageBooth;

use Page;

/**
 * Class \App\ImageBooth\PhotoboxGalleryPage
 *
 * @mixin AssetControlExtension
 * @mixin FileLinkTracking
 * @mixin SiteTreeLinkTracking
 * @mixin RecursivePublishable
 * @mixin VersionedStateExtension
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
