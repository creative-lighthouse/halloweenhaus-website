<?php
namespace App\Events;

use PageController;
use App\Events\Event;
use App\Events\Registration;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\GroupedList;

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
        "attendeeinfo",
        "register",
        "completeregistration",
        "RegistrationForm",
        "registrationsuccessful",
        "registrationfull",
        "eventnotfound",
        "unsubscribe",
        "unsubscribesuccessful",
    ];

    public function view(HTTPRequest $request)
    {
        $id = $this->getRequest()->param("ID");
        $article = Event::get()->byId($id);
        return array(
            "Event" => $article,
        );
    }

    public function attendeeinfo(HTTPRequest $request)
    {
        $hash = $request->param("ID");
        $registration = Registration::get()->filter(array("Hash" => $hash))->First();
        $event = $registration->Event();

        if (isset($hash) && isset($event)) {
            if ($registration) {
                return array(
                    "Event" => $event,
                    "Registration" => $registration,
                );
            }
        }
        user_error("Link unbekannt.");
    }

    public function register(HTTPRequest $request)
    {
        $id = $this->getRequest()->param("ID");
        $article = Event::get()->byId($id);
        return array(
            "Event" => $article,
        );
    }

    public function RegistrationForm()
    {
        $id = $this->getRequest()->param("ID");

        $fields = FieldList::create(
            HiddenField::create("EventID", "EventID", $id),
            HiddenField::create("TimeSlotID", "TimeSlotID"),
            HiddenField::create("GroupSize", "Gruppengröße"),
            TextField::create("Title", "Vor- & Nachname"),
            EmailField::create("Email", "E-Mail-Adresse"),
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
            $registration->Title = $data["Title"];
            $registration->Email = $data["Email"];
            $registration->Hash = md5($data["Email"] . $event->ID . $timeslot->ID . $groupsize . date("Y-m-d H:i:s"));

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

    public function getEvents()
    {
        return Event::get()->filter("EventDate:GreaterThan", date("Y-m-d H:i:s"))->sort("EventDate ASC, StartTime ASC");
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
}
