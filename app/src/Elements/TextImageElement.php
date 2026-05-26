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
 * @property ?string $Embed
 * @property int $ImageID
 * @property int $ButtonID
 * @property int $SecondaryButtonID
 * @method Image Image()
 * @method Link Button()
 * @method Link SecondaryButton()
 * @mixin AssetControlExtension
 * @mixin FileLinkTracking
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
        "Embed" => "Text",
    ];

    private static $has_one = [
        "Image" => Image::class,
        "Button" => Link::class,
        "SecondaryButton" => Link::class,
    ];

    private static $owns = [
        "Image",
        "Button",
        "SecondaryButton",
    ];

    private static $field_labels = [
        "Text" => "Text",
        "Image" => "Bild",
        "Button" => "Primärer Button",
        "SecondaryButton" => "Sekundärer Button",
        "ImageIsLinked" => "Bild verlinkt auch (zum Button-Link)",
        "Embed" => "Embed-Code",
    ];

    private static $table_name = 'TextImageElement';
    private static $icon = 'sp-icon-textimage-element';

    public function getType()
    {
        return "Text + Bild";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("ButtonID");
        $fields->removeByName("SecondaryButtonID");
        $fields->insertAfter('Button', LinkField::create('Button'));
        $fields->insertAfter('SecondaryButton', LinkField::create('SecondaryButton'));
        $fields->replaceField('Variant', DropdownField::create('Variant', 'Variante', [
            "image--left" => "Bild links",
            "image--right" => "Bild rechts",
        ]));
        return $fields;
    }
}
