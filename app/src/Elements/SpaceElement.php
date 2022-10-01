<?php

namespace App\Elements;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;

/**
 * Class \App\Elements\SpaceElement
 *
 * @property int $Height
 */
class SpaceElement extends BaseElement
{

    private static $db = [
        "Height" => "Int(1000)"
    ];

    private static $field_labels = [
        "Height" => "Höhe (in px)"
    ];

    private static $table_name = 'SpaceElement';
    private static $icon = 'font-icon-caret-up-down';

    public function getType() { return "Abstand"; }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
