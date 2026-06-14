<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;

/**
 * Entfernt Fluent-spezifische Felder aus dem LinkField-Formular
 * (da es kein React-UI für RecordLocales hat).
 *
 * @property Link|LinkExtension $owner
 * @property ?string $ButtonType
 */
class LinkExtension extends Extension
{
    private static $db = [
        "ButtonType" => "Varchar(255)",
    ];

    public function updateCMSFields(FieldList $fields): void
    {
        $fields->removeByName('ButtonType');

        //Add dropdown for button type
        $fields->addFieldToTab('Root.Main', DropdownField::create('ButtonType', 'Button Type', [
            'primary' => 'Primary',
            'secondary' => 'Secondary',
        ]));

    }
}
