<?php

namespace App\Elements;

use App\Elements\TeaserItem;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

/**
 * Class \App\Elements\ReportsElement
 *
 * @property string $Text
 * @method \SilverStripe\ORM\DataList|\App\Elements\ReferenceItem[] ReferenceItems()
 */
class ReferencesElement extends BaseElement
{

    private static $db = [
        "Text" => "HTMLText",
    ];

    private static $field_labels = [
        "Text" => "Text",
    ];

    private static $has_many = [
        "ReferenceItems" => ReferenceItem::class,
    ];

    public function inlineEditable() {
        return false;
    }

    private static $table_name = 'ReferencesElement';
    private static $icon = 'icon_block-text';

    public function getType()
    {
        return "Erwähnungen";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("ReferenceItems");

        $gridFieldConfig = GridFieldConfig_RecordEditor::create(200);
        $sorter = new GridFieldSortableRows( 'SortOrder' );
        $gridFieldConfig->addComponent($sorter);
        $gridfield = new GridField( "ReferenceItems", "Erwähnungen", $this->ReferenceItems(), $gridFieldConfig );
        $fields->addFieldToTab( 'Root.Main', $gridfield );
        return $fields;
    }
}
