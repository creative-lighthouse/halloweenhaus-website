<?php

namespace App\Events;

use DateTime;
use App\Events\Event;
use App\Events\EventAdmin;
use Endroid\QrCode\QrCode;
use App\Events\EventTimeSlot;
use SilverStripe\Forms\DropdownField;
use SilverStripe\View\SSViewer;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use SilverStripe\Control\Email\Email;
use Endroid\QrCode\RoundBlockSizeMode;
use SilverStripe\SiteConfig\SiteConfig;
use Endroid\QrCode\ErrorCorrectionLevel;

/**
 * Class \App\Team\TeamMember
 *
 * @property string $Title
 * @property string $Email
 * @property int $GroupSize
 * @property string $Hash
 * @property bool $EmailSent
 * @property string $Status
 * @property string $Type
 * @property int $EventID
 * @property int $TimeSlotID
 * @property int $UsedCouponID
 * @method \App\Events\Event Event()
 * @method \App\Events\EventTimeSlot TimeSlot()
 * @method \App\Events\EventCoupon UsedCoupon()
 */
class Registration extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Email" => "Varchar(255)",
        "GroupSize" => "Int",
        "Hash" => "Varchar(255)",
        "EmailSent" => "Boolean",
        "Status" => "Varchar(255)",
        "Type" => "Varchar(255)",
    ];

    private static $has_one = [
        "Event" => Event::class,
        "TimeSlot" => EventTimeSlot::class,
        "UsedCoupon" => EventCoupon::class,
    ];

    private static $default_sort = "Created ASC";

    private static $field_labels = [
        "Title" => "Name",
        "Email" => "E-Mail",
        "Event" => "Event",
        "TimeSlot" => "Zeitslot",
        "Created" => "Datum",
        "Status" => "Status",
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
        $fields->addFieldsToTab(
            "Root.Main",
            array(
            new DropdownField("Status", "Status", [
                "Registered" => "Registered",
                "Confirmed" => "Confirmed",
                "CheckedIn" => "CheckedIn",
                "Cancelled" => "Cancelled",
            ]))
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
        if ($this->Email != "test@test.de") {
            $emailConfirmation = EmailNotification::create();
            $emailConfirmation->Title = SSViewer::execute_string(SiteConfig::current_site_config()->AckMessageSubject, new ArrayData([
                        "Registration" => $this,
                        "Event" => $this->Event,
                        "Name" => $this->Title,
                        "TimeSlot" => $this->TimeSlot
                    ]));
            $emailConfirmation->Text = SSViewer::execute_string(SiteConfig::current_site_config()->AckMessageContent, new ArrayData([
                        "Registration" => $this,
                        "Event" => $this->Event,
                        "Name" => $this->Title,
                        "TimeSlot" => $this->TimeSlot
                    ]));
            $emailConfirmation->Type = "AckMessage";
            $emailConfirmation->Email = $this->Email;
            $emailConfirmation->Event = $this->Event;
            $emailConfirmation->Registration = $this;
            $emailConfirmation->write();


            $emailNotification = EmailNotification::create();
            $emailNotification->Title = SSViewer::execute_string(SiteConfig::current_site_config()->NewRegisterMessageSubject, new ArrayData([
                "Registration" => $this,
                "Event" => $this->Event,
                "Name" => $this->Title,
                "TimeSlot" => $this->TimeSlot
            ]));
            $emailNotification->Text = SSViewer::execute_string(SiteConfig::current_site_config()->NewRegisterMessageContent, new ArrayData([
                "Registration" => $this,
                "Event" => $this->Event,
                "Name" => $this->Title,
                "TimeSlot" => $this->TimeSlot
            ]));
            $emailNotification->Type = "NewRegistration";
            $emailNotification->Email = "events@halloweenhaus-schmalenbeck.de";
            $emailNotification->Event = $this->Event;
            $emailNotification->Registration = $this;
            $emailNotification->write();

            $this->EmailSent = true;
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
}
