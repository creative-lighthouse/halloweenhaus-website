<?php

namespace App\Elements;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\LinkField\Form\LinkField;
use SilverStripe\Forms\DropdownField;

/**
 * Class \App\Elements\TextImageElement
 *
 * @property string $Text
 * @property string $Variant
 * @property string $ImgWidth
 * @property bool $ImageIsLinked
 * @property int $ImageID
 * @property int $ButtonID
 * @method Image Image()
 * @method Link Button()
 */
class TextImageElement extends BaseElement
{

    private static $db = [
        "Text" => "HTMLText",
        "Variant" => "Varchar(20)",
        "ImgWidth" => "Varchar(20)",
        "ImageIsLinked" => "Boolean"
    ];

    private static $has_one = [
        "Image" => Image::class,
        "Button" => Link::class,
    ];

    private static $owns = [
        "Image"
    ];

    private static $field_labels = [
        "Text" => "Text",
        "Image" => "Bild",
        "Button" => "Button",
        "ImageIsLinked" => "Bild ist verlinkt",
    ];

    private static $table_name = 'TextImageElement';
    private static $icon = 'icon_block-textimage';

    public function getType()
    {
        return "Text+Bild";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("ButtonID");
        $fields->insertAfter('ImgWidth', LinkField::create('Button'));
        $fields->replaceField('Variant', DropdownField::create('Variant', 'Variante', [
            "" => "Bild links",
            "image-right" => "Bild rechts",
        ]));
        $fields->replaceField('ImgWidth', DropdownField::create('ImgWidth', 'Bildbreite', [
            "image-30" => "30%",
            "image-40" => "40%",
            "image-50" => "50%",
            "image-60" => "60%",
            "image-70" => "70%",
        ]));
        return $fields;
    }
}
