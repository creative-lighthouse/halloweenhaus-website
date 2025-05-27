<?php

namespace App\API;

use SilverStripe\CMS\Model\SiteTree;

/**
 * Class \App\API\ApiPage
 *
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
