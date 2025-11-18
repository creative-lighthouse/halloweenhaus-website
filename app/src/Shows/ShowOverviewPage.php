<?php

namespace App\Shows;

use Page;

/**
 * Class \App\Statistics\StatisticsPage
 *
 */
class ShowOverviewPage extends Page
{
    private static $table_name = 'ShowOverviewPage';

    private static $icon = "app/client/icons/show.svg";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
