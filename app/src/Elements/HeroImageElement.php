<?php

namespace App\Elements;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;

/**
 * Class \App\Elements\TextImageElement
 *
 * @property int $ImageBackgroundID
 * @property int $ImageBackground2ID
 * @property int $ImageCharacterID
 * @property int $ImageObjectID
 * @property int $ImageEffectID
 * @property int $ImageEffectOverlayID
 * @method \SilverStripe\Assets\Image ImageBackground()
 * @method \SilverStripe\Assets\Image ImageBackground2()
 * @method \SilverStripe\Assets\Image ImageCharacter()
 * @method \SilverStripe\Assets\Image ImageObject()
 * @method \SilverStripe\Assets\Image ImageEffect()
 * @method \SilverStripe\Assets\Image ImageEffectOverlay()
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
