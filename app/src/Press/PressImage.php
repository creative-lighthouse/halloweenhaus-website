<?php

namespace App\Press;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

/**
 * Class \App\Team\TeamMember
 *
 * @property int $Importance
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image Image()
 */
class PressImage extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Description" => "Text",
        "Importance" => "Int",
    ];

    private static $has_one = [
        "Image" => Image::class,
    ];

    private static $owns = [
        "Image"
    ];

    private static $indexes = [
        'Importance' => true,
    ];

    private static $default_sort = "Importance ASC";

    private static $field_labels = [
    ];

    private static $summary_fields = [
    ];

    private static $searchable_fields = [
    ];

    private static $table_name = "PressImage";

    private static $singular_name = "Presse-Bild";
    private static $plural_name = "Presse-Bilder";

    private static $url_segment = "pressimage";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = PressAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }

    public function getFileExtension()
    {
        $file = $this->Image();
        if ($file) {
            return $file->getExtension();
        }
        return null;
    }

    public function getFileSize()
    {
        $file = $this->Image();
        if ($file) {
            return $file->getAbsoluteSize();
        }
        return null;
    }
}
