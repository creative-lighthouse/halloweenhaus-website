<?php

namespace App\ImageBooth;

use DateTime;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Upload;
use SilverStripe\ORM\DataObject;
use SilverStripe\AssetAdmin\Controller\AssetAdmin;

/**
 * Class \App\Podcast\PodcastEntry
 *
 * @property bool $isVisible
 * @property int $ImageID
 * @method \SilverStripe\Assets\File Image()
 */
class BoothImage extends DataObject
{
    private static $db = [
        "isVisible" => "Boolean",
        "HashID" => "Varchar(5)"
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
        "FormattedIsVisible" => "Sichtbar",
        "FormattedCreationDate" => "Erstellt am"
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

        $now = new DateTime();
        $now = $now->format("Y-m-d H:i:s");

        if (!$this->HashID) {
            $this->HashID = substr(md5(string: $now . $this->ID), 0, 5);
        }
    }

    public function getThumbnail()
    {
        return $this->Image()->CMSThumbnail();
    }

    public function getFormattedCreationDate()
    {
        return $this->dbObject("Created")->Format("dd.MM.YYYY HH:mm:ss");
    }

    public function getFormattedIsVisible()
    {
        return $this->isVisible ? "Ja" : "Nein";
    }
}
