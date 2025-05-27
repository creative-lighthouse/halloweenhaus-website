<?php

namespace App\Elements;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;

/**
 * Class \App\Elements\TextImageElement
 *
 * @property string $Text
 * @property string $Variant
 * @property string $Overlay
 * @property int $Height
 * @property string $Parallax
 * @property int $ImageID
 * @method Image Image()
 */
class ImageBannerElement extends BaseElement
{

    private static $db = [
        "Text" => "Varchar(255)",
        "Variant" => "Varchar(255)",
        "Overlay" => "Varchar(255)",
        "Height" => "Int(1000)",
        "Parallax" => "Varchar(255)"
    ];

    private static $has_one = [
        "Image" => Image::class,
    ];

    private static $owns = [
        "Image"
    ];

    private static $field_labels = [
        "Text" => "Bildunterschrift",
        "Height" => "Höhe (in px)",
        "Image" => "Bild"
    ];

    private static $table_name = 'ImageBannerElement';
    private static $icon = 'font-icon-block-file';

    private static $translate = [
        'Text',
    ];

    public function getType()
    {
        return "Bildbanner";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->replaceField('Variant', DropdownField::create('Variant', 'Variante', [
            "" => "Volle Breite",
            "variant--limited" => "Begrenzte Breite",
            "variant--contained" => "Angepasste Breite",
            "variant--hovering" => "Hervorgehoben",
        ]));
        $fields->replaceField('Overlay', DropdownField::create('Overlay', 'Überlagerung', [
            "" => "Keine Überlagerung",
            "overlay--darker" => "Dunkler",
            "overlay--darkest" => "Am dunkelsten",
            "overlay--brushstroke" => "Pinselstrich",
            "overlay--fadeout_vertical" => "Fadeout Vertical",
            "overlay--fadeout_horizontal" => "Fadeout Horizontal",
        ]));
        $fields->replaceField('Parallax', DropdownField::create('Parallax', 'Parallax', [
            "0" => "Kein Parallax",
            "0.2" => "Normale Geschwindigkeit (0.2)",
            "0.4" => "Hohe Geschwindigkeit (0.4)",
            "0.6" => "Maximale Geschwindigkeit (0.6)",
        ]));
        return $fields;
    }
}
