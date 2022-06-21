<?php

namespace App\Elements;

use SilverStripe\Assets\Image;
use SilverStripe\Security\Permission;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\LinkField\Form\LinkField;
use SilverStripe\ORM\DataObject;

/**
 * Class \App\Elements\TeaserItem
 *
 * @property string $Title
 * @property string $Text
 * @property int $SortOrder
 * @property int $ParentID
 * @property int $ButtonID
 * @method \App\Elements\ReferencesElement Parent()
 * @method \SilverStripe\LinkField\Models\Link Button()
 */
class ReferenceItem extends DataObject {
    private static $db = [
        "Title" => "Varchar(255)",
        "Text" => "HTMLText",
        "SortOrder" => "Int",
    ];

    private static $has_one = [
        "Parent" => ReferencesElement::class,
        "Button" => Link::class,
    ];

    private static $field_labels = [
        "Title" => "Quelle",
        "Text" => "Text",
    ];

    private static $default_sort = 'SortOrder ASC, ID ASC';

    private static $inline_editable = false;

    private static $summary_fields = [
        'ID' => 'ID',
        'Title' => 'Titel',
    ];

    private static $searchable_fields = [
        "Title",
        "Text",
    ];

    private static $table_name = "ReferenceItem";

    private static $singular_name = "Erwähnung";
    private static $plural_name = "Erwähnungen";


    // tidy up the CMS by not showing these fields
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeFieldFromTab("Root.Main","ParentID");
        $fields->removeFieldFromTab("Root.Main","SortOrder");
        $fields->removeByName("ButtonID");
        $fields->insertAfter('Image', LinkField::create('Button'));
        return $fields;
    }

    public function canView($member = null) {
        return true;
    }

    public function canEdit($member = null) {
        return Permission::check('CMS_ACCESS_NewsAdmin', 'any', $member);
    }

    public function canDelete($member = null) {
        return Permission::check('CMS_ACCESS_NewsAdmin', 'any', $member);
    }

    public function canCreate($member = null, $context=[]) {
        return Permission::check('CMS_ACCESS_NewsAdmin', 'any', $member);
    }

}
