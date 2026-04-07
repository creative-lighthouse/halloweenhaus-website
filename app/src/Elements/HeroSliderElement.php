<?php

namespace App\Elements;

use App\Elements\HeroSliderItem;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class \App\Elements\HeroSliderElement
 *
 * @property int $DateFrameID
 * @method Image DateFrame()
 * @method DataList<HeroSliderItem> HeroSliderItems()
 * @mixin FileLinkTracking
 * @mixin AssetControlExtension
 * @mixin SiteTreeLinkTracking
 * @mixin RecursivePublishable
 * @mixin VersionedStateExtension
 */
class HeroSliderElement extends BaseElement
{
    private static $db = [
    ];

    private static $field_labels = [
    ];

    private static $has_one = [
        "DateFrame" => Image::class,
    ];

    private static $has_many = [
        "HeroSliderItems" => HeroSliderItem::class,
    ];

    private static $owns = [
        "DateFrame",
    ];

    public function inlineEditable()
    {
        return false;
    }

    private static $table_name = 'HeroSliderElement';
    private static $icon = 'font-icon-thumbnails';

    public function getType()
    {
        return "Hero Slider";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("HeroSliderItems");

        $gridFieldConfig = GridFieldConfig_RecordEditor::create(200);
        $gridfield = GridField::create("HeroSliderItems", "Hero Slider Items", $this->HeroSliderItems(), $gridFieldConfig);
        $gridfield->getConfig()->addComponent(GridFieldOrderableRows::create('SortOrder'));
        $fields->addFieldToTab('Root.Main', $gridfield);
        return $fields;
    }
}
