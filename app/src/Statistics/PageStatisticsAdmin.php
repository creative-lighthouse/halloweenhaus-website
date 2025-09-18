<?php

namespace App\Statistics;

use SilverStripe\Admin\ModelAdmin;
use App\Statistics\PageStatisticsDay;
use SilverStripe\Forms\GridField\GridField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class PageStatisticsAdmin extends ModelAdmin
{
    private static $managed_models = array(
        PageStatisticsDay::class,
    );

    private static $url_segment = "pagestatistics";

    private static $menu_title = "Aufrufstatistiken";

    private static $menu_icon = "app/client/icons/pagestatistics_admin.svg";

    public function init()
    {
        parent::init();
    }
}
