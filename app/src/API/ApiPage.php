<?php

namespace App\API;

use SilverStripe\CMS\Model\SiteTree;

/**
 * Class \App\API\ApiPage
 *
 * @mixin AssetControlExtension
 * @mixin FileLinkTracking
 * @mixin SiteTreeLinkTracking
 * @mixin RecursivePublishable
 * @mixin VersionedStateExtension
 */
class ApiPage extends SiteTree
{
    private static $table_name = 'ApiPage';

    private static $db = [];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
