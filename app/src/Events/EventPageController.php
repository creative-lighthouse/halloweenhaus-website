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
        "validateticket",
        "checkcoupon",
    ];

    public function index(HTTPRequest $request)
    {
        return array(
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
            if ($coupon->MaxUses > 0 && $coupon->UsedCount >= $coupon->MaxUses) {
                $json["Valid"] = false;
                if ($coupon->MaxUses == 1) {
                    $json["Message"] = "Dieser Code wurde bereits verwendet";
                } else {
                    $json["Message"] = "Dieser Code wurde bereits zu oft verwendet";
                }
            } else {
                $json["Valid"] = true;
                $json["Message"] = "Code gültig";
                $json["Title"] = $coupon->Title;
                $json["Type"] = $coupon->Type;
                $json["Code"] = $coupon->Hash;
                $json["Description"] = $coupon->Description;
            }
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
            NumericField::create("PLZ", "Postleitzahl (optional)")->setHTML5(true),
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

            if ($coupon) {
                $coupon->UsedCount++;
                $coupon->write();
            }

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
        $event_id = $_GET["event"];
        $event = Event::get()->byId($event_id);
        $hash = $_GET["hash"];

        if (!isset($hash)) {
            return user_error("Unbekannter Hash");
        }
        if (!isset($event)) {
            return user_error("Unbekanntes Event");
        }

        $registration = Registration::get()->filter(array(
            "Hash" => $hash,
            "EventID" => $event_id,
        ))->First();

        if ($registration) {
            $registration->Status = "Confirmed";
            $registration->write();
            return array(
                "Event" => $event,
                "Registration" => $registration,
            );
        } else {
            user_error("Hash passt zu keiner Registrierung");
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

    public function validateticket(HTTPRequest $request)
    {
        $hash = $request->param("ID");
        $json = array();
        $json["Valid"] = false;
        $json["Message"] = "Ungültiger Code";

        if (isset($hash)) {
            $registration = Registration::get()->filter(array("Hash" => $hash))->First();

            //Return JSON from the data

            if ($registration) {
                //Check if Timeslot is now plus 10 minutes and minus 10 minutes
                if (strtotime($registration->Event()->EventDate) - strtotime(date("Y-m-d H:i:s")) < 600 && strtotime($registration->Event()->EventDate) - strtotime(date("Y-m-d H:i:s")) > -600) {
                    $json["Valid"] = true;
                    $json["Message"] = "Ticket gültig";
                    $json["Name"] = $registration->Title;
                    $json["TimeSlot"] = $registration->TimeSlot()->Title;
                    $json["SlotTime"] = $registration->TimeSlot()->SlotTime;
                    $json["Event"] = $registration->Event()->Title;
                    $json["GroupSize"] = $registration->GroupSize;
                    $json["QRCode"] = $registration->getQRCode();
                } else {
                    $json["Valid"] = false;
                    $json["Message"] = "Ticket nicht gültig";
                    $json["TimeSlot"] = $registration->TimeSlot()->Title;
                    $json["Event"] = $registration->Event()->Title;
                }
            }
        }
        $this->response->addHeader('Content-Type', 'application/json');
        return json_encode($json);
    }

    public function getFeedbackPageLink()
    {
        $feedbackPage = FeedbackPage::get()->first();
        return $feedbackPage->Link();
    }
}
