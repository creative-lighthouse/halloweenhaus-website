<?php
namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Versioned\Versioned;

/**
 * Class \App\Extensions\ElementExtension
 *
 * @property BaseElement|ElementExtension $owner
 * @property bool $ElementIsHidden
 */
class ElementExtension extends Extension
{
    private static $db = [
        'ElementIsHidden' => 'Boolean',
    ];

    private static $field_labels = [
        "ElementIsHidden" => "Element is hidden (only show in draft mode)",
    ];

    public function shouldShowElement()
    {
        if (!$this->owner->ElementIsHidden) {
            return true;
        }

        if (Versioned::get_stage() === Versioned::DRAFT) {
            return true;
        }

        return false;
    }

    public function getIsDraftVersion()
    {
        return Versioned::get_stage() === Versioned::DRAFT;
    }

    public function updateStatusFlags(&$flags)
    {
        if ($this->owner->ElementIsHidden) {
            $flags['element-hidden'] = [
                'text' => 'Hidden',
                'title' => 'This element is hidden (only visible in draft mode)',
            ];
        }
    }
}