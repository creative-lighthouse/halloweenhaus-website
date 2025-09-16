<?php

namespace App\Elements;

use SilverStripe\Assets\Image;
use DNADesign\Elemental\Models\BaseElement;

/**
 * Class \App\Elements\HeroVideoElement
 *
 * @property string $EmbedCode
 */
class HeroVideoElement extends BaseElement
{

    private static $db = [
        "EmbedCode" => "Text",
        "DirectVideo" => "Varchar(512)",
    ];

    private static $has_one = [
        "DateFrame" => Image::class,
    ];

    private static $owns = [
        "DateFrame",
    ];

    private static $field_labels = [];

    private static $table_name = 'HeroVideoElement';
    private static $icon = 'font-icon-globe';

    public function getType()
    {
        return "Hero-Video";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
