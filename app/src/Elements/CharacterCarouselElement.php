<?php

namespace App\Elements;

use App\Team\Character;
use SilverStripe\Assets\Image;
use DNADesign\Elemental\Models\BaseElement;

/**
 * Class \App\Elements\CharacterCarouselElement
 *
 * @property ?string $Text
 * @property int $BackgroundImageID
 * @method Image BackgroundImage()
 * @mixin AssetControlExtension
 * @mixin FileLinkTracking
 * @mixin SiteTreeLinkTracking
 * @mixin RecursivePublishable
 * @mixin VersionedStateExtension
 */
class CharacterCarouselElement extends BaseElement
{

    private static $db = [
        "Text" => "HTMLText",
    ];

    private static $field_labels = [
        "Text" => "Text",
    ];

    private static $table_name = 'CharacterCarouselElement';
    private static $icon = 'font-icon-torsos-all';

    private static $has_one = [
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
        return $fields;
    }

    public function getCharacters()
    {
        return Character::get()->Filter("InCarousel", true);
    }
}
