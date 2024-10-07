<?php

namespace App\ImageBooth;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

/**
 * Class \App\Podcast\PodcastEntry
 *
 * @property bool $isVisible
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image Image()
 */
class BoothImage extends DataObject
{
    private static $db = [
        "isVisible" => "Boolean",
    ];

    private static $has_one = [
        "Image" => Image::class
    ];

    private static $owns = [
        "Image"
    ];

    private static $default_sort = "Created DESC";

    private static $field_labels = [
        "isVisible" => "Sichtbar in Gallerie",
        "Image" => "Bild"
    ];

    private static $summary_fields = [
        "Thumbnail" => "Thumbnail",
        "isVisible" => "Sichtbar in Gallerie",
        "Created" => "Erstellt am"
    ];

    private static $table_name = "BoothImage";

    private static $singular_name = "Fotobox-Bild";
    private static $plural_name = "Fotobox Bilder";

    private static $url_segment = "boothimage";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
    }

    public function getThumbnail()
    {
        return $this->Image()->ScaleWidth(60);
    }
}
