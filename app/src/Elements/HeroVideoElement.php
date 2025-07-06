<?php

namespace App\Elements;

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
    ];

    private static $has_one = [];

    private static $owns = [];

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
