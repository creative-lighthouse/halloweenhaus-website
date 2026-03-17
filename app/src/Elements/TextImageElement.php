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
 * @property ?string $Text
 * @property ?string $Variant
 * @property bool $ImageIsLinked
 * @property int $ImageID
 * @property int $ButtonID
 * @method Image Image()
 * @method Link Button()
 * @mixin FileLinkTracking
 * @mixin AssetControlExtension
 * @mixin SiteTreeLinkTracking
 * @mixin RecursivePublishable
 * @mixin VersionedStateExtension
 */
class TextImageElement extends BaseElement
{
    private static $db = [
        "Text" => "HTMLText",
        "Variant" => "Varchar(50)",
        "ImageIsLinked" => "Boolean",
    ];

    private static $has_one = [
        "Image" => Image::class,
        "Button" => Link::class,
    ];

    private static $owns = [
        "Image",
        "Button",
    ];

    private static $field_labels = [
        "Text" => "Text",
        "Image" => "Bild",
        "Button" => "Button",
        "ImageIsLinked" => "Bild verlinkt auch (zum Button-Link)",
    ];

    private static $table_name = 'TextImageElement';
    private static $icon = 'stevens-icon-textimage';

    public function getType()
    {
        return "Text + Bild";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("ButtonID");
        $fields->insertAfter('Button', LinkField::create('Button'));
        $fields->replaceField('Variant', DropdownField::create('Variant', 'Variante', [
            "image--left" => "Bild links",
            "image--right" => "Bild rechts",
        ]));
        return $fields;
    }
}
