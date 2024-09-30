<?php

namespace {

    use App\Events\Event;

    use App\Events\EntryLog;
    use App\Events\Registration;
    use SilverStripe\Assets\Image;

    use App\ExperienceDatabase\Experience;
    use App\ExperienceDatabase\ExperienceData;
    use App\ExperienceDatabase\ExperienceLocation;
    use App\ExperienceDatabase\LogEntry;
    use App\Overview\LocationPage;
    use App\Ratings\Rating;
    use SilverStripe\Security\Member;
    use SilverStripe\Control\HTTPRequest;
    use SilverStripe\Core\Injector\Injector;
    use SilverStripe\Security\IdentityStore;
    use SilverStripe\Security\Security;
    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\ORM\Queries\SQLSelect;

    /**
     * Class \PageController
     *
     * @property \ApiPage $dataRecord
     * @method \ApiPage data()
     * @mixin \ApiPage
     */
    class ApiPageController extends ContentController
    {
        private static $allowed_actions = [
            "checkCode",
            "checkIn",
            "enterShow",
            "acceptTicket",
            "acceptTicket",
        ];

        public function index(HTTPRequest $request)
        {
            $this->response->addHeader('Content-Type', 'application/json');
            return json_encode(["message" => "API is running."]);
        }

        public function checkCode(HTTPRequest $request)
        {
            $registration = Registration::get()->filter("Hash", $request->param("ID"))->first();

            if ($registration) {
                $data['Valid'] = true;
                $data['Name'] = $registration->Title;
                $timeslotTime = $registration->TimeSlot()->SlotTime;
                $eventdate = $registration->Event()->EventDate;
                //combine date and time into one string
                $data['TimeSlot'] = date("d.m.Y H:i", strtotime($eventdate . " " . $timeslotTime));
                $data['Event'] = $registration->Event()->Title;
                $data['EventID'] = $registration->EventID;
                $data['GroupSize'] = $registration->GroupSize;

                switch ($registration->Status) {
                    case "Registered":
                        $data['Message'] = "Ticket wurde nicht bestätigt.";
                        $data['Status'] = "Registered";
                        break;
                    case "CheckedIn":
                        $data['Message'] = "Ticket wurde bereits eingecheckt.";
                        $data['Status'] = "CheckedIn";
                        break;
                    case "Cancelled":
                        $data['Message'] = "Ticket wurde storniert.";
                        $data['Status'] = "Cancelled";
                        break;
                    default:
                        $data['Message'] = "Code ist gültig.";
                        $data['Status'] = "Confirmed";
                        break;
                }
            } else {
                $data['Valid'] = false;
                $data['Message'] = "Code ist ungültig.";
            }

            $this->response->addHeader('Content-Type', 'application/json');
            return json_encode($data);
        }

        public function acceptTicket(HTTPRequest $request)
        {
            $registration = Registration::get()->filter("Hash", $request->param("ID"))->first();

            if ($registration) {
                $registration->Status = "CheckedIn";
                $registration->write();
                $data['Valid'] = true;
                $data['Message'] = "Ticket wurde akzeptiert.";
            } else {
                $data['Valid'] = false;
                $data['Message'] = "Code ist ungültig.";
            }

            $this->response->addHeader('Content-Type', 'application/json');
            return json_encode($data);
        }

        public function enterShow(HTTPRequest $request)
        {
            //Get data from request body
            $entereddata = json_decode($request->getBody(), true);
            $sq = $entereddata['sq'];
            $vq = $entereddata['vq'];
            $tt = $entereddata['tt'];

            $entryLog = new EntryLog();
            $entryLog->SQ = $sq;
            $entryLog->VQ = $vq;
            $entryLog->EntryTime = date("Y-m-d H:i:s");
            $entryLog->write();

            $data['Valid'] = true;

            $this->response->addHeader('Content-Type', 'application/json');
            return json_encode($data);
        }

        public function checkIn(HTTPRequest $request)
        {
            $currentUser = Security::getCurrentUser();

            $event_id = $_GET["event"];
            $event = Event::get()->byId($event_id);
            $hash = $_GET["hash"];

            $data['Hash'] = $hash;
            $data['Event'] = $event_id;

            if (!isset($hash) || !isset($event)) {
                $data['Valid'] = true;
                $data['Message'] = "Ungültiges Event oder Hash";
                $data['GroupSize'] = 0;
            } else {
                $registration = Registration::get()->filter(array(
                    "Hash" => $hash,
                    "EventID" => $event_id,
                ))->First();

                if ($registration) {
                    if ($currentUser) {
                        $registration->Status = "CheckedIn";
                        $registration->write();

                        $data['Valid'] = true;
                        $data['Message'] = "Gast wurde eingecheckt.";
                        $data['GroupSize'] = $registration->GroupSize;
                    } else {
                        $data['Valid'] = false;
                        $data['Message'] = "Nicht eingeloggt!";
                        $data['GroupSize'] = 0;
                    }
                } else {
                    $data['Valid'] = false;
                    $data['Message'] = "Ein Fehler ist aufgetreten.";
                    $data['Hash'] = $hash;
                    $data['GroupSize'] = 0;
                }
            }

            $this->response->addHeader('Content-Type', 'application/json');
            return json_encode($data);
        }
    }
}
