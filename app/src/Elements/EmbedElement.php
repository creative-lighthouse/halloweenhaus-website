<?php

namespace App\Elements;

use DNADesign\Elemental\Models\BaseElement;

/**
 * Class \App\Elements\EmbedElement
 *
 * @property string $EmbedCode
 */
class EmbedElement extends BaseElement
{

    private static $db = [
        "EmbedCode" => "Text",
    ];

    private static $table_name = 'EmbedElement';
    private static $icon = 'font-icon-monitor';

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Embed');
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
