<?php

namespace App\Elements;

use App\Team\TeamApplicationInterest;
use DNADesign\Elemental\Models\BaseElement;

/**
 * Class \App\Elements\ApplicationElement
 *
 * @property ?string $Text
 * @property ?string $SuccessText
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
        "SuccessText" => "HTMLText",
    ];

    private static $field_labels = [
        "Text" => "Einleitungstext",
        "SuccessText" => "Erfolgstext (wird nach dem Absenden angezeigt)",
    ];

    private static $table_name = 'ApplicationElement';
    private static $icon = 'sp-icon-job-element';

    private static $controller_class = ApplicationElementController::class;

    public function getType()
    {
        return "Application Element";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        return $fields;
    }

    public function getInterests()
    {
        return TeamApplicationInterest::get();
    }
}
