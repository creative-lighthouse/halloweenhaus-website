<?php

namespace App\Podcast;

use App\Podcast\PodcastEntry;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class \App\Podcast\PodcastAdmin
 *
 */
class PodcastAdmin extends ModelAdmin
{

    private static $managed_models = array(
        PodcastEntry::class,
    );

    private static $url_segment = "podcast";

    private static $menu_title = "Podcast";

    private static $menu_icon = "app/client/icons/podcast_admin.svg";

    public function init()
    {
        parent::init();
    }
}
