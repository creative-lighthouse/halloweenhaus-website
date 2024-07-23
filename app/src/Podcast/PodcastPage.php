<?php

namespace App\Podcast;

use Page;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;

/**
 * Class \App\Podcast\PodcastPage
 *
 * @property string $Title
 * @property string $Description
 * @property int $CoverImageID
 * @method \SilverStripe\Assets\Image CoverImage()
 */
class PodcastPage extends Page
{
    private static $table_name = 'PodcastPage';

    private static $db = [
        "Title" => "Varchar(255)",
        "Description" => "HTMLText",
    ];

    private static $has_one = [
        "CoverImage" => Image::class,
    ];

    private static $owns = [
        "CoverImage"
    ];

    private static $icon = "app/client/icons/podcast_page.svg";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab("Root.Main", $coverImage = UploadField::create("CoverImage", "Cover Image"));
        return $fields;
    }
}
