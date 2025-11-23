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
 * @property ?string $TitleAlign
 * @property ?string $BackgroundColor
 * @property bool $OnlyNearHalloween
 * @property ?string $Variant
 * @property ?string $ImgWidth
 * @property bool $ImageIsLinked
 * @property ?string $ButtonAlign
 * @property int $ImageID
 * @property int $ButtonID
 * @method Image Image()
 * @method Link Button()
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
        "TitleAlign" => "Varchar(50)",
        "BackgroundColor" => "Varchar(50)",
        "OnlyNearHalloween" => "Boolean",
        "Variant" => "Varchar(50)",
        "ImgWidth" => "Varchar(50)",
        "ImageIsLinked" => "Boolean",
        "ButtonAlign" => "Varchar(50)",
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
        "OnlyNearHalloween" => "Nur nahe Halloween zu sehen",
    ];

    private static $table_name = 'TextImageElement';
    private static $icon = 'font-icon-block-promo-3';

    public function getType()
    {
        return "Text+Bild";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("ButtonID");
        $fields->insertAfter('Button', LinkField::create('Button'));
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
            "image-100" => "100%",
        ]));
        $fields->replaceField('BackgroundColor', DropdownField::create('BackgroundColor', 'Hintergrundfarbe', [
            "color--background-transparent" => "Transparent",
            "color--background-light" => "Hellgrau"
        ]));
        $fields->insertAfter('Title', DropdownField::create('TitleAlign', 'Titel-Ausrichtung', [
            "" => "Automatisch",
            "style--title-left" => "Linksbündig",
            "style--title-center" => "Zentriert",
            "style--title-right" => "Rechtsbündig",
        ]));
        $fields->insertAfter('Button', DropdownField::create('ButtonAlign', 'Button-Ausrichtung', [
            "" => "Automatisch",
            "style--button-left" => "Linksbündig",
            "style--button-center" => "Zentriert",
            "style--button-right" => "Rechtsbündig",
        ]));
        return $fields;
    }
}
