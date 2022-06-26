<?php

namespace App\Elements;

use SilverStripe\Assets\Image;
use App\Elements\SocialBannerItem;
use SilverStripe\Forms\DropdownField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

/**
 * Class \App\Elements\TextImageElement
 *
 * @property string $Text
 * @method \SilverStripe\ORM\DataList|\App\Elements\SocialBannerItem[] Socials()
 */
class SocialBannerElement extends BaseElement
{

    private static $db = [
        "Text" => "Varchar(255)",
    ];

    private static $has_many = [
        "Socials" => SocialBannerItem::class,
    ];

    private static $owns = [
        "Socials"
    ];

    private static $field_labels = [
        "Text" => "Text",
    ];

    public function inlineEditable() {
        return false;
    }

    private static $table_name = 'SocialBannerElement';
    private static $icon = 'font-icon-block-file';

    public function getType()
    {
        return "Soziales Banner";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("Socials");

        $gridFieldConfig = GridFieldConfig_RecordEditor::create(200);
        $sorter = new GridFieldSortableRows( 'SortOrder' );
        $gridFieldConfig->addComponent($sorter);
        $gridfield = new GridField( "Socials", "Soziale Links", $this->Socials(), $gridFieldConfig );
        $fields->addFieldToTab( 'Root.Main', $gridfield );
        return $fields;
    }
}
