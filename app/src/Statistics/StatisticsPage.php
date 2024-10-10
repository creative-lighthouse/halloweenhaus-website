<?php

namespace App\Statistics;

use Page;

/**
 * Class \App\Team\TeamOverview
 *
 */
class StatisticsPage extends Page
{
    private static $table_name = 'StatisticsPage';

    private static $icon = "app/client/icons/statistics.svg";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
