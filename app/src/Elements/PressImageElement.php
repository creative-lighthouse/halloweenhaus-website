<?php

namespace App\Elements;

use App\Press\PressImage;
use DNADesign\Elemental\Models\BaseElement;

/**
 * Class \App\Elements\TeaserElement
 *
 * @property ?string $Text
 * @mixin AssetControlExtension
 * @mixin FileLinkTracking
 * @mixin SiteTreeLinkTracking
 * @mixin RecursivePublishable
 * @mixin VersionedStateExtension
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
