<?php

namespace App\Events;

use DateTime;
use App\Events\Event;
use App\Events\EventAdmin;
use SilverStripe\Assets\Image;
use SilverStripe\View\SSViewer;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\LinkField\Form\LinkField;

/**
 * Class \App\Team\TeamMember
 *
 * @property string $Title
 * @property string $Email
 * @property string $Hash
 * @property bool $EmailSent
 * @property int $EventID
 * @method \App\Events\Event Event()
 */
class Registration extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Email" => "Varchar(255)",
        "Hash" => "Varchar(255)",
        "EmailSent" => "Boolean",
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

    function onAfterWrite()
    {
        parent::onAfterWrite();

        if (!$this->EmailSent) {
            $this->sendReceiveConfirmation();
        }
    }

    public function sendReceiveConfirmation()
    {
        $emailConfirmation = EmailNotification::create();
        $emailConfirmation->Title = SSViewer::execute_string(SiteConfig::current_site_config()->AckMessageSubject, new ArrayData([
                    "Registration" => $this,
                    "Event" => $this->Event,
                    "Name" => $this->Title,
                ]));
        $emailConfirmation->Text = SSViewer::execute_string(SiteConfig::current_site_config()->AckMessageContent, new ArrayData([
                    "Registration" => $this,
                    "Event" => $this->Event,
                    "Name" => $this->Title
                ]));
        $emailConfirmation->Type = "AckMessage";
        $emailConfirmation->Email = $this->Email;
        $emailConfirmation->Event = $this->Event;
        $emailConfirmation->Registration = $this;
        $emailConfirmation->write();

        $emailNotification = EmailNotification::create();
        $emailNotification->Title = "[HWHS] - " . $this->Event->Title . " - Neue Anmeldung - " . $this->Title;
        $emailNotification->Text = "
        Eine neue Anmeldung von " . $this->Title . " ist für das Event '" . $this->Event->Title . "' eingegangen.<br/>";
        $emailNotification->Type = "NewRegistration";
        $emailNotification->Email = "events@halloweenhaus-schmalenbeck.de";
        $emailNotification->Event = $this->Event;
        $emailNotification->Registration = $this;
        $emailNotification->write();

        $this->EmailSent = true;
        $this->write();
    }

    public function getAttendeeLink()
    {
        $holder = EventPage::get()->sort("ID", "ASC")->First();
        if ($holder) {
            return $holder->AbsoluteLink("attendeeinfo/") . $this->Hash;
        }
        return "/404";
    }

    public function getUnsubscribeLink()
    {
        $holder = EventPage::get()->sort("ID", "ASC")->First();
        if ($holder) {
            return $holder->AbsoluteLink("unsubscribe/") . $this->Hash;
        }
        return "/404";
    }
}
