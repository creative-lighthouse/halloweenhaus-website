<?php

namespace App\POS;

use App\Feedback\FeedbackEntry;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class \App\Team\TeamAdmin
 *
 */
class POSAdmin extends ModelAdmin
{

    private static $managed_models = array(
        Product::class,
        Sale::class,
        DonationCount::class,
    );

    private static $url_segment = "pos";

    private static $menu_title = "POS";

    private static $menu_icon = "app/client/icons/pos_admin.svg";

    public function init()
    {
        parent::init();
    }
}
