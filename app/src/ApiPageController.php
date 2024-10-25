<?php

namespace {

    use App\POS\DonationCount;

    use App\POS\Sale;
    use App\POS\ProductSale;

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
            "statistics",
            "addPOSSale",
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



        //STATISTICS API
        public function statistics(HTTPRequest $request)
        {
            $this->response->addHeader('Content-Type', 'application/json');
            if (!isset($_GET["type"])) {
                return json_encode(["message" => "No valid type given."]);
            }
            $type = $_GET["type"];

            switch ($type) {
                case "GuestsThisYear":
                    return $this->getStat_GuestsThisYear();
                    break;
                case "GuestsPerDay":
                    return $this->getStat_GuestsPerDay();
                    break;
                case "SalesPerDay":
                    return $this->getStat_SalesPerDay();
                    break;
                case "ProfitsPerDay":
                    return $this->getStat_ProfitsPerDay();
                    break;
                case "RegistrationsPerDay":
                    return $this->getStat_RegistrationsPerDay();
                    break;
                case "GuestsPerHour":
                    return $this->getStat_GuestsPerHour();
                    break;
                case "RegistrationsPerHour":
                    return $this->getStat_RegistrationsPerHour();
                    break;
                case "SalesPerHour":
                    return $this->getStat_SalesPerHour();
                    break;
                case "VQRegistrationsPerDay":
                    return $this->getStat_VQRegistrationsPerDay();
                    break;
                case "VQGuestsThisYear":
                    return $this->getStat_VQGuestsThisYear();
                    break;
                case "VQGuestsPerDay":
                    return $this->getStat_VQGuestsPerDay();
                    break;
                default:
                    return json_encode(["message" => "No valid type given."]);
            }
        }

        public function getStat_GuestsThisYear()
        {
            //Get all entry logs
            $entryLogs = EntryLog::get()->filter(array(
                "EntryTime:GreaterThanOrEqual" => date("Y-01-01"),
                "EntryTime:LessThanOrEqual" => date("Y-12-31"),
            ));

            //Calculate People by groupsize of registrations
            $data['GuestsThisYear'] = [
                'VQ' => 0,
                'SQ' => 0,
                'TT' => 0,
            ];
            foreach ($entryLogs as $entryLog) {
                $entryLogVQ = $entryLog->VQ;
                $entryLogSQ = $entryLog->SQ;
                $entryLogTT = $entryLog->getTotalGuests();
                $data['GuestsThisYear']['VQ'] += $entryLogVQ;
                $data['GuestsThisYear']['SQ'] += $entryLogSQ;
                $data['GuestsThisYear']['TT'] += $entryLogTT;
            }

            return json_encode($data);
        }

        public function getStat_GuestsPerDay()
        {
            //Get all entry logs
            $entryLogs = EntryLog::get()->filter(array(
                "EntryTime:GreaterThanOrEqual" => date("Y-01-01"),
                "EntryTime:LessThanOrEqual" => date("Y-12-31"),
            ));

            //Split the entry logs into days
            $days = [];

            foreach ($entryLogs as $entryLog) {
                $day = date("Y-m-d", strtotime($entryLog->EntryTime));
                if (!isset($days[$day])) {
                    $days[$day] = [
                        'VQ' => $entryLog->VQ,
                        'SQ' => $entryLog->SQ,
                        'TT' => $entryLog->getTotalGuests(),
                    ];
                } else {
                    $days[$day]['VQ'] += $entryLog->VQ;
                    $days[$day]['SQ'] += $entryLog->SQ;
                    $days[$day]['TT'] += $entryLog->getTotalGuests();
                }
            }

            //Sort the array by date
            ksort($days);

            $data = $days;

            return json_encode($data);
        }

        public function getStat_RegistrationsPerDay()
        {
            //Get all entry logs
            $registrations = Registration::get()->filter(array(
                "Event.EventDate:GreaterThanOrEqual" => date("Y-01-01"),
                "Event.EventDate:LessThanOrEqual" => date("Y-12-31"),
            ));

            //Split the entry logs into days
            $days = [];

            foreach ($registrations as $registration) {
                $day = date("Y-m-d", strtotime($registration->Created));
                if (!isset($days[$day])) {
                    $days[$day] = $registration->GroupSize;
                } else {
                    $days[$day] += $registration->GroupSize;
                }
            }

            //Sort the array by date
            ksort($days);

            $data = $days;

            return json_encode($data);
        }

        public function getStat_SalesPerDay()
        {
            //Get all entry logs
            $sales = Sale::get()->filter(array(
                "SaleTime:GreaterThanOrEqual" => date("Y-01-01"),
                "SaleTime:LessThanOrEqual" => date("Y-12-31"),
            ));

            //Split the entry logs into days
            $days = [];

            foreach ($sales as $sale) {
                $productamount = 0;
                foreach ($sale->ProductSales() as $productSale) {
                    $productamount += $productSale->Amount;
                }
                $day = date("Y-m-d", strtotime($sale->SaleTime));
                if (!isset($days[$day])) {
                    $days[$day] = $productamount;
                } else {
                    $days[$day] += $productamount;
                }
            }

            //Sort the array by date
            ksort($days);

            $data = $days;

            return json_encode($data);
        }

        public function getStat_ProfitsPerDay()
        {
            //Get all entry logs
            $sales = Sale::get()->filter(array(
                "SaleTime:GreaterThanOrEqual" => date("Y-01-01"),
                "SaleTime:LessThanOrEqual" => date("Y-12-31"),
            ));

            $donationCounts = DonationCount::get()->filter(array(
                "CountDateTime:GreaterThanOrEqual" => date("Y-01-01"),
                "CountDateTime:LessThanOrEqual" => date("Y-12-31"),
            ));

            //Split the entry logs into days
            $days = [];

            foreach ($sales as $sale) {
                $profit = 0;
                foreach ($sale->ProductSales() as $productSale) {
                    $profit += $productSale->Amount * ($productSale->SellingPrice - $productSale->Product()->BuyPrice);
                }
                $day = date("Y-m-d", strtotime($sale->SaleTime));
                if (!isset($days[$day])) {
                    $days[$day] = $profit;
                } else {
                    $days[$day] += $profit;
                }
            }

            foreach ($donationCounts as $donationCount) {
                $day = date("Y-m-d", strtotime($donationCount->CountDateTime));
                if (!isset($days[$day])) {
                    $days[$day] = $donationCount->Amount;
                } else {
                    $days[$day] += $donationCount->Amount;
                }
            }

            //Sort the array by date
            ksort($days);

            $data = $days;

            return json_encode($data);
        }

        public function getStat_RegistrationsPerHour()
        {
            //Get all registrations for this year
            $registrations = Registration::get()->filter(array(
                "Event.EventDate:GreaterThanOrEqual" => date("Y-01-01"),
                "Event.EventDate:LessThanOrEqual" => date("Y-12-31"),
            ))->sort("Created");

            //Split the registrations into hours
            $hours = [];

            foreach ($registrations as $registration) {
                $hour = date("Y-m-d H:00", strtotime($registration->Created));
                if (!isset($hours[$hour])) {
                    $hours[$hour] = $registration->GroupSize;
                } else {
                    $hours[$hour] += $registration->GroupSize;
                }
            }

            $data = $hours;

            return json_encode($data);
        }

        public function getStat_GuestsPerHour()
        {
            //Get all entry logs
            $entryLogs = EntryLog::get()->filter(array(
                "EntryTime:GreaterThanOrEqual" => date("Y-01-01"),
                "EntryTime:LessThanOrEqual" => date("Y-12-31"),
            ))->sort("EntryTime");

            //Split the entry logs into hours
            $hours = [];

            foreach ($entryLogs as $entryLog) {
                $hour = date("Y-m-d H:00", strtotime($entryLog->EntryTime));
                if (!isset($hours[$hour])) {
                    $hours[$hour] = [
                        'VQ' => $entryLog->VQ,
                        'SQ' => $entryLog->SQ,
                        'TT' => $entryLog->getTotalGuests(),
                    ];
                } else {
                    $hours[$hour]['VQ'] += $entryLog->VQ;
                    $hours[$hour]['SQ'] += $entryLog->SQ;
                    $hours[$hour]['TT'] += $entryLog->getTotalGuests();
                }
            }

            $data = $hours;

            return json_encode($data);
        }

        public function getStat_SalesPerHour()
        {
            //Get all entry logs
            $sales = Sale::get()->filter(array(
                "SaleTime:GreaterThanOrEqual" => date("Y-01-01"),
                "SaleTime:LessThanOrEqual" => date("Y-12-31"),
            ))->sort("SaleTime");

            //Split the entry logs into hours
            $hours = [];

            foreach ($sales as $sale) {
                $productamount = 0;
                foreach ($sale->ProductSales() as $productSale) {
                    $productamount += $productSale->Amount;
                }
                $hour = date("Y-m-d H:00", strtotime($sale->SaleTime));
                if (!isset($hours[$hour])) {
                    $hours[$hour] = $productamount;
                } else {
                    $hours[$hour] += $productamount;
                }
            }

            $data = $hours;

            return json_encode($data);
        }

        public function getStat_VQGuestsThisYear()
        {
            //Get all registrations for this year
            $registrations = Registration::get()->filter(array(
                "Event.EventDate:GreaterThanOrEqual" => date("Y-01-01"),
                "Event.EventDate:LessThanOrEqual" => date("Y-12-31"),
                "Status" => "CheckedIn",
            ));

            //Calculate People by groupsize of registrations
            $data['GuestsThisYear'] = 0;
            foreach ($registrations as $registration) {
                $data['GuestsThisYear'] += $registration->GroupSize;
            }

            return json_encode($data);
        }

        public function getStat_VQGuestsPerDay()
        {
            //Get all registrations for this year
            $registrations = Registration::get()->filter(array(
                "Event.EventDate:GreaterThanOrEqual" => date("Y-01-01"),
                "Event.EventDate:LessThanOrEqual" => date("Y-12-31"),
                "Status" => "CheckedIn",
            ));

            //Split the registrations into days
            $days = [];

            foreach ($registrations as $registration) {
                $day = date("Y-m-d", strtotime($registration->Event()->EventDate));
                if (!isset($days[$day])) {
                    $days[$day] = $registration->GroupSize;
                } else {
                    $days[$day] += $registration->GroupSize;
                }
            }

            $data['GuestsPerDay'] = $days;

            return json_encode($data);
        }

        public function getStat_VQRegistrationsPerDay()
        {
            //Get all registrations for this year
            $registrations = Registration::get()->filter(array(
                "Event.EventDate:GreaterThanOrEqual" => date("Y-01-01"),
                "Event.EventDate:LessThanOrEqual" => date("Y-12-31"),
            ));

            //Split the registrations into days
            $days = [];

            foreach ($registrations as $registration) {
                $day = date("Y-m-d", strtotime($registration->Created));
                if (!isset($days[$day])) {
                    $days[$day] = 1;
                } else {
                    $days[$day] += 1;
                }
            }

            $data['RegistrationsPerDay'] = $days;

            return json_encode($data);
        }

        public function addPOSSale(HTTPRequest $request)
        {
            $currentUser = Security::getCurrentUser();

            if ($currentUser) {
                if ($request->getBody() == null) {
                    $this->response->addHeader('Content-Type', 'application/json');
                    return json_encode(["message" => "No data found."]);
                }

                //Get data from request body
                $entereddata = json_decode($request->getBody(), true);
                $products = $entereddata['products'];
                $total = $entereddata['total'];

                $sale = new Sale();
                $sale->SaleTime = date("Y-m-d H:i:s");
                $sale->write();

                foreach ($products as $product) {
                    $productSale = new ProductSale();
                    $productSale->ProductID = $product['id'];
                    $productSale->Amount = $product['amount'];
                    $productSale->SellingPrice = $product['price'];
                    $productSale->ParentID = $sale->ID;
                    $productSale->write();
                }

                $sale->TotalPrice = $total;
                $sale->write();

                $data['Valid'] = true;

                $this->response->addHeader('Content-Type', 'application/json');
                return json_encode($data);
            } else {
                $this->response->addHeader('Content-Type', 'application/json');
                return json_encode(["message" => "Not logged in."]);
            }
        }
    }
}
