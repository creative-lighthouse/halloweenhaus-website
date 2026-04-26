<?php

namespace App\Elements;

use DNADesign\Elemental\Models\BaseElement;

/**
 * Class \App\Elements\ApplicationElement
 *
 * @property ?string $Text
 * @mixin FileLinkTracking
 * @mixin AssetControlExtension
 * @mixin SiteTreeLinkTracking
 * @mixin RecursivePublishable
 * @mixin VersionedStateExtension
 */
class ApplicationElement extends BaseElement
{
    private static $db = [
        "Text" => "HTMLText",
    ];

    private static $field_labels = [
        "Text" => "Text",
    ];

    private static $table_name = 'ApplicationElement';
    private static $icon = 'sp-icon-job-element';

    public function getType()
    {
        return "Application Element";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        return $fields;
    }
}
