<?php

namespace App\Elements;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;

/**
 * Class \App\Elements\TextImageElement
 *
 * @property int $ImageBackgroundID
 * @property int $ImageBackground2ID
 * @property int $ImageCharacterID
 * @property int $ImageObjectID
 * @property int $ImageEffectID
 * @property int $ImageEffectOverlayID
 * @method Image ImageBackground()
 * @method Image ImageBackground2()
 * @method Image ImageCharacter()
 * @method Image ImageObject()
 * @method Image ImageEffect()
 * @method Image ImageEffectOverlay()
 */
class HeroImageElement extends BaseElement
{

    private static $db = [
    ];

    private static $has_one = [
        "ImageBackground" => Image::class,
        "ImageBackground2" => Image::class,
        "ImageCharacter" => Image::class,
        "ImageObject" => Image::class,
        "ImageEffect" => Image::class,
        "ImageEffectOverlay" => Image::class,
    ];

    private static $owns = [
        "ImageBackground",
        "ImageBackground2",
        "ImageCharacter",
        "ImageObject",
        "ImageEffect",
        "ImageEffectOverlay"
    ];

    private static $field_labels = [
    ];

    private static $table_name = 'HeroImageElement';
    private static $icon = 'font-icon-block-file';

    public function getType()
    {
        return "Hero-Bild";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
