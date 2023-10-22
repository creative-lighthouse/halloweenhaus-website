<?php

namespace App\Events;

use DateTime;
use App\Events\Event;
use App\Events\EventAdmin;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\LinkField\Form\LinkField;

/**
 * Class \App\Team\TeamMember
 *
 * @property string $Title
 * @property string $Email
 * @property string $Hash
 * @property int $EventID
 * @method \App\Events\Event Event()
 */
class Registration extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Email" => "Varchar(255)",
        "Hash" => "Varchar(255)",
    ];

    private static $has_one = [
        "Event" => Event::class,
    ];

    private static $default_sort = "Created ASC";

    private static $field_labels = [
        "Title" => "Name",
        "Email" => "E-Mail",
        "Event" => "Event",
    ];

    private static $summary_fields = [
        "Title" => "Name",
        "Email" => "E-Mail",
        "Created" => "Datum",
    ];

    private static $searchable_fields = [
        "Title", "Email",
    ];

    private static $table_name = "Registration";

    private static $singular_name = "Registrierung";
    private static $plural_name = "Registrierungen";

    private static $url_segment = "registrations";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = EventAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }

    function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $now = new DateTime();
        $now = $now->format("Y-m-d H:i:s");

        if (!$this->Hash) {
            $this->Hash = substr(md5($now . $this->Title . $this->Email), 0, 8);
        }
    }
}
