<?php

namespace App\Elements;

use App\Elements\TeaserItem;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

/**
 * Class \App\Elements\TeaserElement
 *
 * @property string $Text
 * @method \SilverStripe\ORM\DataList|\App\Elements\TeaserItem[] TeaserItems()
 */
class TeaserElement extends BaseElement
{

    private static $db = [
        "Text" => "HTMLText",
    ];

    private static $field_labels = [
        "Text" => "Text",
    ];

    private static $has_many = [
        "TeaserItems" => TeaserItem::class,
    ];

    public function inlineEditable() {
        return false;
    }

    private static $table_name = 'TeaserElement';
    private static $icon = 'icon_block-text';

    public function getType()
    {
        return "Teaser";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("TeaserItems");

        $gridFieldConfig = GridFieldConfig_RecordEditor::create(200);
        $sorter = new GridFieldSortableRows( 'SortOrder' );
        $gridFieldConfig->addComponent($sorter);
        $gridfield = new GridField( "TeaserItems", "Teaser", $this->TeaserItems(), $gridFieldConfig );
        $fields->addFieldToTab( 'Root.Main', $gridfield );
        return $fields;
    }
}
