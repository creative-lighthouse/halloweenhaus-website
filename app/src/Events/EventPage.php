<?php

namespace App\Events;

use Page;
use SilverStripe\Assets\Image;

use SilverStripe\AssetAdmin\Forms\UploadField;

/**
 * Class \App\Events\EventPage
 *
 * @property int $HeaderImageID
 * @method Image HeaderImage()
 */
class EventPage extends Page
{
    private static $table_name = 'EventPage';

    private static $has_one = [
        "HeaderImage" => Image::class,
    ];

    private static $owns = [
        "HeaderImage"
    ];

    private static $icon = "app/client/icons/events_admin.svg";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab("Root.Main", UploadField::create("HeaderImage", "Headerbild"));
        return $fields;
    }
}
