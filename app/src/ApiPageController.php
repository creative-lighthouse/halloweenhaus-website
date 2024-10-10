<?php

namespace {

    use SilverStripe\Forms\Form;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\FileField;
    use SilverStripe\Forms\TextField;
    use SilverStripe\Forms\FormAction;

    use Endroid\QrCode\Builder\Builder;
    use Endroid\QrCode\Writer\PngWriter;
    use Endroid\QrCode\Encoding\Encoding;
    use Endroid\QrCode\RoundBlockSizeMode;
    use Endroid\QrCode\ErrorCorrectionLevel;

    use App\ImageBooth\PhotoboxGalleryPage;
    use App\ImageBooth\BoothImage;
    use App\Events\Event;
    use App\Events\EntryLog;
    use App\Events\Registration;
    use SilverStripe\Control\HTTPRequest;
    use SilverStripe\Security\Security;
    use SilverStripe\CMS\Controllers\ContentController;

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
            "cancelTicket",
            "addImageFromBooth",
            "BoothImageEntryForm",
            "submitBoothImage",
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
                        //if day is today and timeslot is not more than 20 minutes in the past or future
                        if (date("Y-m-d", strtotime($eventdate)) == date("Y-m-d") && strtotime($timeslotTime) > strtotime("-20 minutes") && strtotime($timeslotTime) < strtotime("+20 minutes")) {
                            $data['Message'] = "Ticket ist gültig.";
                            $data['Status'] = "Confirmed";
                        } else {
                            $data['Message'] = "Ticket ist aktuell nicht gültig.";
                            $data['Status'] = "Registered";
                        }
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

        public function cancelTicket(HTTPRequest $request)
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
            }

            if ($registration) {
                $registration->Status = "Cancelled";
                $registration->write();
                $data['Valid'] = true;
                $data['Message'] = "Ticket wurde gecancelt.";
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

        //Get Image from base64 string in API call and save to database
        public function addImageFromBooth(HTTPRequest $request)
        {
            $data = json_decode($request->getBody(), true);
            if (!isset($data['image'])) {
                $this->response->addHeader('Content-Type', 'application/json');
                return json_encode(["message" => "No image data found."]);
            }

            $photogallery = PhotoboxGalleryPage::get()->first();

            $boothImage = new BoothImage();
            $boothImage->Base64Image = $data['image'];
            $boothImage->isVisible = true;
            $boothImage->write();
            $returndata["message"] = "Image saved.";
            $returndata["id"] = $boothImage->ID;

            if ($photogallery) {
                $returndata["detaillink"] = $photogallery->AbsoluteLink("foto") . "/" . $boothImage->ID;
                $returndata["qrlink"] = $this->createQRCode($photogallery->AbsoluteLink("foto") . "/" . $boothImage->ID);
            }


            $this->response->addHeader('Content-Type', 'application/json');
            return json_encode($returndata);
        }

        public function createQRCode(String $link)
        {
            $qrCode = Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                ->data($link)
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

        public function BoothImageEntryForm()
        {
            $fields = FieldList::create([
                //            TextField::create('Name'),
                //            EmailField::create('Email'),
                TextField::create('Hash'),
                FileField::create('Image')->setFolderName('BoothImages'),
            ]);
            $actions = FieldList::create([
                FormAction::create('submit', 'Submit'),
            ]);
            return Form::create($this, 'BoothImageEntryForm', $fields, $actions)
                ->disableSecurityToken();
        }

        public function submit($data, $form)
        {
            $entry = new BoothImage();
            $form->saveInto($entry);
            $entry->isVisible = true;
            $entry->write();

            $photogallery = PhotoboxGalleryPage::get()->first();
            if ($photogallery) {
                $returndata["detaillink"] = $photogallery->AbsoluteLink("foto") . "/" . $entry->ID;
                $returndata["qrlink"] = $this->createQRCode($photogallery->AbsoluteLink("foto") . "/" . $entry->ID);
            }


            $this->response->addHeader('Content-Type', 'application/json');
            return json_encode($returndata);
        }
    }
}
