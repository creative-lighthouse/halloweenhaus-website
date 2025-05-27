<?php

namespace App\POS;

use SilverStripe\Admin\ModelAdmin;

/**
 * Class \App\POS\POSAdmin
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
