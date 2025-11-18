<?php

namespace App\Shows;

use Page;

/**
 * Class \App\Statistics\StatisticsPage
 *
 * @property ?string $Description
 * @mixin FileLinkTracking
 * @mixin AssetControlExtension
 * @mixin SiteTreeLinkTracking
 * @mixin RecursivePublishable
 * @mixin VersionedStateExtension
 */
class ShowOverviewPage extends Page
{
    private static $db = [
        "Description" => "Text",
    ];

    private static $table_name = 'ShowOverviewPage';

    private static $icon = "app/client/icons/show.svg";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
