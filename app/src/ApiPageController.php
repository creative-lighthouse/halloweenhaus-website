<?php

namespace {

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
            "enterShow",
            "acceptTicket",
            "acceptTicket",
        ];

        public function checkCode(HTTPRequest $request)
        {
            $registration = Registration::get()->filter("Hash", $request->param("ID"))->first();

            if ($registration) {
                $data['Valid'] = true;
                $data['Message'] = "Code ist gültig.";
                $data['Name'] = $registration->Name;
                $data['TimeSlot'] = $registration->TimeSlot()->SlotTime;
                $data['Event'] = $registration->Event()->Title;
                $data['GroupSize'] = $registration->GroupSize;
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
            $entryLog->TT = $tt;
            $entryLog->write();

            $data['Valid'] = true;

            $this->response->addHeader('Content-Type', 'application/json');
            return json_encode($data);
        }
    }
}
