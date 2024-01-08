<?php

namespace App\Elements;

use App\Press\PressImage;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

/**
 * Class \App\Elements\TeaserElement
 *
 * @property string $Text
 */
class PressImageElement extends BaseElement
{

    private static $db = [
        "Text" => "HTMLText",
    ];

    private static $field_labels = [
        "Text" => "Text",
    ];

    public function inlineEditable()
    {
        return true;
    }

    private static $table_name = 'PressImageElement';
    private static $icon = 'font-icon-block-content';

    public function getType()
    {
        return "Presse-Bilder";
    }

    public function getPressImages()
    {
        return PressImage::get();
    }
}
