<?php

namespace App\Feedback;

use App\Feedback\FeedbackAdmin;
use SilverStripe\ORM\DataObject;

/**
 * Class \App\Team\TeamSocial
 *
 * @property int $Day
 * @property float $Stars
 * @property string $Comment
 * @property string $PLZ
 */
class FeedbackEntry extends DataObject
{
    private static $db = [
        "Day" => "Int",
        "Stars" => "Double",
        "Comment" => "Text",
        "PLZ"=> "Varchar(255)",
    ];

    private static $default_sort = "Day ASC, Created DESC";

    private static $field_labels = [
        "Day" => "Tag",
        "Stars" => "Sterne",
        "Comment" => "Kommentar",
        "PLZ" => "PLZ",
    ];

    private static $summary_fields = [
        "Created" => "Erstellt",
        "Day" => "Tag",
        "Stars" => "Sterne",
        "PLZ" => "PLZ",
    ];

    private static $table_name = "FeedbackEntry";

    private static $singular_name = "Feedback";
    private static $plural_name = "Feedbacks";

    private static $url_segment = "feedbackentry";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }

    private static $inline_editable = true;

    public function CMSEditLink()
    {
        $admin = FeedbackAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }
}
