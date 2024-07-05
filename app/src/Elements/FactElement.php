<?php

namespace App\Elements;

use App\Elements\FactItem;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

/**
 * Class \App\Elements\ReportsElement
 *
 * @property string $Text
 * @method \SilverStripe\ORM\DataList|\App\Elements\FactItem[] FactItems()
 */
class FactElement extends BaseElement
{

    private static $db = [
        "Text" => "HTMLText",
    ];

    private static $field_labels = [
        "Text" => "Text",
    ];

    private static $has_many = [
        "FactItems" => FactItem::class,
    ];

    public function inlineEditable()
    {
        return false;
    }

    private static $table_name = 'FactElement';
    private static $icon = 'font-icon-info-circled';

    public function getType()
    {
        return "Fakten";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("FactItems");

        $gridFieldConfig = GridFieldConfig_RecordEditor::create(200);
        $sorter = new GridFieldSortableRows('SortOrder');
        $gridFieldConfig->addComponent($sorter);
        $gridfield = new GridField("FactItems", "Fakten", $this->FactItems(), $gridFieldConfig);
        $fields->addFieldToTab('Root.Main', $gridfield);
        return $fields;
    }
}
