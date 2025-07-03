<?php

namespace App\Events;

use DateTime;
use App\Events\Event;
use App\Events\EventAdmin;
use App\Events\EventTimeSlot;
use SilverStripe\View\SSViewer;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use SilverStripe\Forms\DropdownField;
use Endroid\QrCode\RoundBlockSizeMode;
use SilverStripe\SiteConfig\SiteConfig;
use Endroid\QrCode\ErrorCorrectionLevel;

/**
 * Class \App\Events\Registration
 *
 * @property string $Title
 * @property string $Email
 * @property int $GroupSize
 * @property string $Hash
 * @property string $ConfirmEmailSent
 * @property string $TicketEmailSent
 * @property string $Status
 * @property string $Type
 * @property string $ZIP
 * @property int $EventID
 * @property int $TimeSlotID
 * @property int $UsedCouponID
 * @method Event Event()
 * @method EventTimeSlot TimeSlot()
 * @method EventCoupon UsedCoupon()
 */
class Registration extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Email" => "Varchar(255)",
        "GroupSize" => "Int",
        "Hash" => "Varchar(255)",
        "ConfirmEmailSent" => "Datetime",
        "TicketEmailSent" => "Datetime",
        "Status" => "Varchar(255)",
        "Type" => "Varchar(255)",
        "ZIP" => "Varchar(5)",
    ];

    private static $has_one = [
        "Event" => Event::class,
        "TimeSlot" => EventTimeSlot::class,
        "UsedCoupon" => EventCoupon::class,
    ];

    private static $default_sort = "Status ASC, Created DESC";

    private static $field_labels = [
        "Title" => "Name",
        "Email" => "E-Mail",
        "Event" => "Event",
        "TimeSlot" => "Zeitslot",
        "Created" => "Datum",
        "Status" => "Status",
        "GroupSize" => "Gruppengröße",
        "ZIP" => "PLZ",
    ];

    private static $summary_fields = [
        "StatusText" => "Status",
        "Title" => "Name",
        "Email" => "E-Mail",
        "ZIP" => "PLZ",
        "Created" => "Datum",
    ];

    private static $searchable_fields = [
        "Title",
        "Email",
    ];

    private static $table_name = "Registration";

    private static $singular_name = "Registrierung";
    private static $plural_name = "Registrierungen";

    private static $url_segment = "registrations";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            "Root.Main",
            array(
                DropdownField::create("Status", "Status", [
                    "Registered" => "Registered",
                    "Confirmed" => "Confirmed",
                    "CheckedIn" => "CheckedIn",
                    "Cancelled" => "Cancelled",
                ])
            )
        );
        $fields->removeByName("Type");

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
            $this->Hash = substr(md5(string: $now . $this->Title . $this->Email), 0, 8);
        }
    }

    function onAfterWrite()
    {
        parent::onAfterWrite();

        if ($this->ConfirmEmailSent == null && SiteConfig::current_site_config()->EmailsActive) {
            $this->sendReceiveConfirmation();
        }
        if ($this->Status == "Confirmed" && $this->TicketEmailSent == null && SiteConfig::current_site_config()->EmailsActive) {
            $this->sendTicketEmail();
        }
    }

    public function sendReceiveConfirmation()
    {
        if ($this->Email != "test@test.de") {
            $eventpage = EventPage::get()->first();
            $confirmLink = $eventpage->AbsoluteLink("registrationconfirm?event=" . $this->EventID . "&hash=" . $this->Hash);

            //Send email to client
            $emailConfirmation = EmailNotification::create();
            $emailConfirmation->Title = SSViewer::execute_string(SiteConfig::current_site_config()->AckMessageSubject, ArrayData::create([
                "Registration" => $this,
                "Event" => $this->Event,
                "Name" => $this->Title,
                "TimeSlot" => $this->TimeSlot
            ]));
            $emailConfirmation->Text = SSViewer::execute_string(SiteConfig::current_site_config()->AckMessageContent, ArrayData::create([
                "Registration" => $this,
                "Event" => $this->Event,
                "Name" => $this->Title,
                "TimeSlot" => $this->TimeSlot,
                "ConfirmLink" => $confirmLink
            ]));
            $emailConfirmation->Type = "AckMessage";
            $emailConfirmation->Email = $this->Email;
            $emailConfirmation->Event = $this->Event;
            $emailConfirmation->Registration = $this;
            $emailConfirmation->write();


            //Send email to admin
            $emailNotification = EmailNotification::create();
            $emailNotification->Title = SSViewer::execute_string(SiteConfig::current_site_config()->NewRegisterMessageSubject, ArrayData::create([
                "Registration" => $this,
                "Event" => $this->Event,
                "Name" => $this->Title,
                "TimeSlot" => $this->TimeSlot
            ]));
            $emailNotification->Text = SSViewer::execute_string(SiteConfig::current_site_config()->NewRegisterMessageContent, ArrayData::create([
                "Registration" => $this,
                "Event" => $this->Event,
                "Name" => $this->Title,
                "TimeSlot" => $this->TimeSlot
            ]));
            $emailNotification->Type = "NewRegistration";
            $emailNotification->Email = SiteConfig::current_site_config()->EventAdminEmail;
            $emailNotification->Event = $this->Event;
            $emailNotification->Registration = $this;
            $emailNotification->write();

            $now = date("Y-m-d H:i:s");
            $this->ConfirmEmailSent = date("Y-m-d H:i:s", strtotime($now));
            $this->write();
        }
    }

    public function sendTicketEmail()
    {
        if ($this->Email != "test@test.de") {
            $eventpage = EventPage::get()->first();
            $confirmLink = $eventpage->AbsoluteLink("ticket/" . $this->Hash);

            //Send email to client
            $emailConfirmation = EmailNotification::create();
            $emailConfirmation->Title = SSViewer::execute_string(SiteConfig::current_site_config()->TicketMessageSubject, ArrayData::create([
                "Registration" => $this,
                "Event" => $this->Event,
                "Name" => $this->Title,
                "TimeSlot" => $this->TimeSlot
            ]));
            $emailConfirmation->Text = SSViewer::execute_string(SiteConfig::current_site_config()->TicketMessageContent, ArrayData::create([
                "Registration" => $this,
                "Event" => $this->Event,
                "Name" => $this->Title,
                "TimeSlot" => $this->TimeSlot,
                "TicketLink" => $confirmLink
            ]));
            $emailConfirmation->Type = "AckMessage";
            $emailConfirmation->Email = $this->Email;
            $emailConfirmation->Event = $this->Event;
            $emailConfirmation->Registration = $this;
            $emailConfirmation->write();

            $now = date("Y-m-d H:i:s");
            $this->TicketEmailSent = date("Y-m-d H:i:s", strtotime($now));
            $this->write();
        }
    }

    public function getTicketLink()
    {
        $holder = EventPage::get()->sort("ID", "ASC")->First();
        if ($holder) {
            return $holder->AbsoluteLink("ticket") . "/" . $this->Hash;
        }
        return "/404";
    }

    public function getUnsubscribeLink()
    {
        $holder = EventPage::get()->sort("ID", "ASC")->First();
        if ($holder) {
            return $holder->AbsoluteLink("unsubscribe") . "/" . $this->Hash;
        }
        return "/404";
    }

    public function getQRCode()
    {
        $validateLink = EventAdminPage::get()->first()->AbsoluteLink("checkRegistration") . "/" . $this->Hash;

        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($validateLink)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->validateResult(false)
            ->build();
        header('Content-Type: ' . $qrCode->getMimeType());
        return $qrCode->getDataUri();
    }

    public function getStatusText()
    {
        switch ($this->Status) {
            case "Registered":
                return "Registriert";
            case "Confirmed":
                return "Bestätigt";
            case "CheckedIn":
                return "Eingecheckt";
            case "Cancelled":
                return "Gelöscht";
        }
    }
}
