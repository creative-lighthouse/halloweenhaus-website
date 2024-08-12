<?php
namespace App\Events;

use PageController;
use App\Events\Event;
use App\Events\Registration;
use SilverStripe\Forms\Form;
use App\Feedback\FeedbackPage;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\GroupedList;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Control\Email\Email;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\RequiredFields;

/**
 * Class \App\Team\TeamOverviewController
 *
 * @property \App\Events\EventPage $dataRecord
 * @method \App\Events\EventPage data()
 * @mixin \App\Events\EventPage
 */
class EventPageController extends PageController
{

    private static $allowed_actions = [
        "view",
        "register",
        "completeregistration",
        "RegistrationForm",
        "registrationsuccessful",
        "registrationfull",
        "registrationconfirm",
        "couponinvalid",
        "eventnotfound",
        "unsubscribe",
        "unsubscribesuccessful",
        "ticket",
        "checkcoupon",
    ];

    public function index(HTTPRequest $request)
    {
        return array
        (
            "UsesCoupon" => $request->getVar("coupon"),
        );
    }

    public function view(HTTPRequest $request)
    {
        $id = $this->getRequest()->param("ID");
        $article = Event::get()->byId($id);
        return array(
            "Event" => $article,
        );
    }

    public function register(HTTPRequest $request)
    {
        $id = $this->getRequest()->param("ID");
        $article = Event::get()->byId($id);
        return array(
            "Event" => $article,
        );
    }

    public function checkCoupon(HTTPRequest $request)
    {
        $hash = $this->getRequest()->param("ID");

        $json = array();
        $json["Valid"] = false;
        $json["Message"] = "Ungültiger Code";

        $coupon = EventCoupon::get()->filter("Hash", $hash)->First();

        if ($coupon) {
            $json["Valid"] = true;
            $json["Message"] = "Code gültig";
            $json["Title"] = $coupon->Title;
            $json["Type"] = $coupon->Type;
            $json["Code"] = $coupon->Hash;
            $json["Description"] = $coupon->Description;
        }

        $this->response->addHeader('Content-Type', 'application/json');
        return json_encode($json);
    }

    public function RegistrationForm()
    {
        $id = $this->getRequest()->param("ID");

        $fields = FieldList::create(
            HiddenField::create("EventID", "EventID", $id),
            HiddenField::create("TimeSlotID", "TimeSlotID"),
            HiddenField::create("GroupSize", "Gruppengröße"),
            HiddenField::create("Couponcode", "Couponcode"),
            TextField::create("Title", "Vor- & Nachname"),
            EmailField::create("Email", "E-Mail-Adresse"),
            NumericField::create("PLZ", "Postleitzahl (optional)"),
            LiteralField::create("DataPrivacyinfo", "Ich habe die <a href='impressum-and-datenschutz'>Datenschutzerklärung</a> gelesen und willige ein, dass meine Daten im Sinne der DSGVO verwendet werden."),
            CheckboxField::create("DataPrivacy", "Datenschutzerklärung akzeptieren"),
        );

        $actions = FieldList::create(
            FormAction::create("completeregistration")->setTitle("Absenden")
        );

        $required = RequiredFields::create(
            "Title",
            "EventID",
            "TimeSlotID",
            "GroupSize",
            "Title",
            "Email",
            "DataPrivacy"
        );

        $form = Form::create($this, "RegistrationForm", $fields, $actions, $required);

        return $form;
    }

    public function completeregistration($data, $form)
    {
        $event = Event::get()->byId($data["EventID"]);
        $timeslot = EventTimeSlot::get()->byId($data["TimeSlotID"]);
        $groupsize = $data["GroupSize"];
        $zip = $data["PLZ"];
        $couponcode = $data["Couponcode"];
        $coupon = null;

        if ($couponcode) {
            $coupon = EventCoupon::get()->filter("Hash", $couponcode)->First();
            if (!$coupon) {
                return $this->redirect($this->Link("couponinvalid/$event->ID"));
            }
        }

        $registrations = Registration::get()->filter("EventID", $event->ID)->filter("TimeSlotID", $timeslot->ID);
        $timeslotRegistrationCount = 0;
        foreach ($registrations as $registration) {
            $timeslotRegistrationCount += $registration->GroupSize;
        }

        if ($timeslotRegistrationCount + $groupsize > $timeslot->MaxAttendees) {
            return $this->redirect($this->Link("registrationfull/$event->ID"));
        } else {
            $registration = Registration::create();
            $registration->EventID = $event->ID;
            $registration->TimeSlotID = $timeslot->ID;
            $registration->GroupSize = $groupsize;
            $registration->ZIP = $zip;
            $registration->Title = $data["Title"];
            $registration->Email = $data["Email"];
            if ($coupon) {
                $registration->UsedCouponID = $coupon->ID;
            }
            $registration->Hash = md5($data["Email"] . $event->ID . $timeslot->ID . $groupsize . date("Y-m-d H:i:s"));
            $registration->Status = "Registered";

            $registration->write();

            return $this->redirect($this->Link("registrationsuccessful/$event->ID/$registration->Hash"));
        }
    }

    public function registrationsuccessful(HTTPRequest $request)
    {
        $event_id = $request->param("ID");
        $event = Event::get()->byId($event_id);
        $hash = $request->param("OtherID");

        if (isset($hash) && isset($event)) {
            $registration = Registration::get()->filter(array("Hash" => $hash))->First();
            if ($registration) {
                return array(
                    "Event" => $event,
                    "Registration" => $registration,
                );
            }
        } else {
            user_error("Unbekannter Hash");
        }
    }

    public function registrationfull(HTTPRequest $request)
    {
        $event_id = $request->param("ID");
        $event = Event::get()->byId($event_id);

        if (isset($event)) {
            return array(
                "Event" => $event,
            );
        } else {
            $this->redirect($this->Link("eventnotfound"));
        }
    }

    public function registrationconfirm(HTTPRequest $request)
    {
        $event_id = $request->param("ID");
        $event = Event::get()->byId($event_id);
        $hash = $request->param("OtherID");
        if (isset($hash) && isset($event)) {
            $registration = Registration::get()->filter(array(
                "Hash"=> $hash,
                "EventID" => $event->ID,
                ))->First();
            if ($registration) {
                $registration->Status = "Confirmed";
                $registration->write();
                return array(
                    "Event" => $event,
                    "Registration" => $registration,
                );
            }
        }
    }

    public function getEvents()
    {
        return Event::get()->filter("EventDate:GreaterThanOrEqual", date("Y-m-d H:i:s"))->sort("EventDate ASC, StartTime ASC");
    }

    public function getGroupedEvents()
    {
        $events = $this->getEvents();
        return GroupedList::create($events);
    }

    public function unsubscribe(HTTPRequest $request)
    {
        $hash = $request->param("ID");

        if (isset($hash)) {
            $registration = Registration::get()->filter(array("Hash" => $hash))->First();
            if ($registration) {
                $registration->delete();
                return $this->redirect($this->Link("unsubscribesuccessful"));
            }
        }
        return $this->redirect($this->Link("eventnotfound"));
    }

    public function ticket(HTTPRequest $request)
    {
        $hash = $request->param("ID");

        if (isset($hash)) {
            $registration = Registration::get()->filter(array("Hash" => $hash))->First();
            if ($registration) {

                //$qrcode = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2Fwww.google.com%2F&choe=UTF-8";

                return array(
                    "Registration" => $registration,
                );
            }
        }
        return $this->redirect($this->Link("eventnotfound"));
    }

    public function getFeedbackPageLink()
    {
        $feedbackPage = FeedbackPage::get()->first();
        return $feedbackPage->Link();
    }
}
