<?php

namespace App\ImageBooth;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Upload;
use SilverStripe\ORM\DataObject;
use SilverStripe\AssetAdmin\Controller\AssetAdmin;

/**
 * Class \App\Podcast\PodcastEntry
 *
 * @property bool $isVisible
 * @property string $Base64Image
 * @property int $ImageID
 * @method \SilverStripe\Assets\File Image()
 */
class BoothImage extends DataObject
{
    private static $db = [
        "isVisible" => "Boolean",
        "Base64Image" => "Text"
    ];

    private static $has_one = [
        "Image" => File::class
    ];

    private static $owns = [
        "Image"
    ];

    private static $default_sort = "Created DESC";

    private static $field_labels = [
        "isVisible" => "Sichtbar in Gallerie",
        "Base64Image" => "Bild-Code"
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
        //create Thumbnail from Base64Image
        $image = Image::create();

        $image->setFromString($this->Base64Image, "thumbnail.jpg");

        return $image->CMSThumbnail();
    }

    public function getFormattedCreationDate()
    {
        return date("d.m.Y H:i", strtotime($this->Created));
    }
}
