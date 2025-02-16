<?php

namespace App\FleaMarket;

use SilverStripe\Admin\ModelAdmin;
use App\FleaMarket\FleaMarketProductCategory;

/**
 * Class \App\FleaMarket\FleaMarketAdmin
 *
 */
class FleaMarketAdmin extends ModelAdmin
{

    private static $managed_models = array(
        FleaMarketProduct::class,
        FleaMarketProductCategory::class,
    );

    private static $url_segment = "fleamarket";

    private static $menu_title = "Flohmarkt";

    private static $menu_icon = "app/client/icons/fleamarket_admin.svg";

    public function init()
    {
        parent::init();
    }

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        return $form;
    }
}
