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
use SilverStripe\Security\Security;

/**
 * Class \App\Team\TeamOverviewController
 *
 * @property \App\Events\EventAdminPage $dataRecord
 * @method \App\Events\EventAdminPage data()
 * @mixin \App\Events\EventAdminPage
 */
class EventAdminPageController extends PageController
{

    private static $allowed_actions = [
        "checkRegistration",
    ];

    public function checkRegistration(HTTPRequest $request)
    {
        $currentUser = Security::getCurrentUser();
        $hash = $this->getRequest()->param("ID");
        $registration = Registration::get()->filter("Hash", $hash)->first();
        $eventPage = EventPage::get()->first();

        if ($registration) {
            if ($currentUser) {
                return array(
                    "Registration" => $registration,
                );
            } else {
                return $this->redirect($eventPage->Link("ticket") . "/" . $registration->Hash);
            }
        } else {
            return $this->redirect($eventPage->Link("eventnotfound"));
        }
    }
}
