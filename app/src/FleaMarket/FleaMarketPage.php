<?php

namespace App\FleaMarket;

use Page;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

/**
 * Class \App\FleaMarket\FleaMarketPage
 *
 * @property string $Text
 */
class FleaMarketPage extends Page
{
    private static $db = [
        "Text" => "HTMLText",
    ];

    private static $table_name = 'FleaMarketPage';

    private static $icon = "app/client/icons/fleamarket.svg";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab("Root.Main", HTMLEditorField::create("Text", "Text"), "Content");
        return $fields;
    }
}
