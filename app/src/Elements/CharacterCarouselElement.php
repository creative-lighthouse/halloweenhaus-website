<?php

namespace App\Elements;

use App\Team\Character;
use SilverStripe\Assets\Image;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\LinkField\Form\LinkField;
use DNADesign\Elemental\Models\BaseElement;

/**
 * Class \App\Elements\CharacterCarouselElement
 *
 * @property string $Text
 * @property int $ButtonID
 * @property int $BackgroundImageID
 * @method \SilverStripe\LinkField\Models\Link Button()
 * @method \SilverStripe\Assets\Image BackgroundImage()
 */
class CharacterCarouselElement extends BaseElement
{

    private static $db = [
        "Text" => "HTMLText",
    ];

    private static $field_labels = [
        "Text" => "Text",
        "Button" => "Button"
    ];

    private static $table_name = 'CharacterCarouselElement';
    private static $icon = 'icon_block-text';

    private static $has_one = [
        "Button" => Link::class,
        "BackgroundImage" => Image::class,
    ];

    private static $owns = [
        "BackgroundImage",
    ];

    public function getType()
    {
        return "CharacterCarousel";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("ButtonID");
        $fields->insertAfter('ColorVariant', LinkField::create('Button'));
        return $fields;
    }

    public function getCharacters(){
        return Character::get();
    }
}
