<?php
namespace App\Feedback;

use App\Feedback\FeedbackEntry;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class \App\Team\TeamAdmin
 *
 */
class FeedbackAdmin extends ModelAdmin
{

    private static $managed_models = array (
        FeedbackEntry::class,
    );

    private static $url_segment = "feedback";

    private static $menu_title = "Feedback";

    private static $menu_icon = "app/client/icons/feedback_admin.svg";

    public function init()
    {
        parent::init();
    }
}
