<?php

namespace App\Feedback;

use Page;

/**
 * Class \App\Feedback\FeedbackPage
 *
 */
class FeedbackPage extends Page
{
    private static $table_name = 'FeedbackPage';

    private static $icon = "app/client/icons/feedbackgray.svg";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
