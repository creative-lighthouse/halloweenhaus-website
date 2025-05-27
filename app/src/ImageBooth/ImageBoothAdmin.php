<?php

namespace App\ImageBooth;

use App\ImageBooth\BoothImage;
use SilverStripe\Admin\ModelAdmin;
use Colymba\BulkManager\BulkManager;
use SilverStripe\Forms\GridField\GridFieldConfig;

/**
 * Class \App\ImageBooth\ImageBoothAdmin
 *
 */
class ImageBoothAdmin extends ModelAdmin
{

    private static $managed_models = array(
        BoothImage::class,
    );

    private static $url_segment = "imagebooth";

    private static $menu_title = "Fotobox";

    private static $menu_icon = "app/client/icons/imagebooth_admin.svg";

    public function init()
    {
        parent::init();
    }

    protected function getGridFieldConfig(): GridFieldConfig
    {
        $config = parent::getGridFieldConfig();

        $config->addComponent(BulkManager::create(), 'GridFieldEditButton');

        return $config;
    }
}
