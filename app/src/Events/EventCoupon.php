<?php

namespace App\Events;

use DateTime;
use App\Events\EventAdmin;
use App\Events\Registration;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBTime;
use SilverStripe\ORM\FieldType\DBDatetime;

/**
 * Class \App\Team\TeamMember
 *
 * @property string $Title
 * @property string $Description
 * @property string $Type
 * @property string $Hash
 */
class EventCoupon extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Description" => "Text",
        "Type" => "Varchar(255)",
        "Hash" => "Varchar(255)",
    ];

    private static $belongs_many = [
        "Registrations" => Registration::class,
    ];

    private static $default_sort = "Title ASC";

    private static $field_labels = [
        "Title" => "Titel",
        "Description" => "Beschreibung",
        "Type" => "Typ",
        "Hash" => "Code",
    ];

    private static $summary_fields = [
        "Title" => "Titel",
        "Type" => "Typ",
        "UsedCount" => "Anzahl Verwendet",
    ];

    private static $searchable_fields = [
        "Title",
        "Type",
        "Hash",
    ];

    private static $table_name = "EventCoupon";

    private static $singular_name = "Coupon";
    private static $plural_name = "Coupons";

    private static $url_segment = "coupon";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab("Root.Main", new DropdownField("Type", "Type", [
            "Standard" => "Standard",
            "VIP" => "VIP",
            "Press" => "Press",
            "Staff" => "Staff",
        ]));
        return $fields;
    }

    public function getUsedCount()
    {
        return Registration::get()->filter("UsedCouponID", $this->ID)->count();
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $now = new DateTime();
        $now = $now->format("Y-m-d H:i:s");
        if (!$this->Hash) {
            $this->Hash = substr(md5($now . $this->Title . $this->Email), 0, 8);
        }
    }
}
