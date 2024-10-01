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
        "checkIn",
        "cancel",
    ];

    public function index(HTTPRequest $request)
    {
        $currentuser = Security::getCurrentUser();
        if (!$currentuser) {
            return $this->redirect("Security/login");
        } else {
            return $this->renderWith(["App/Events/EventAdminPage", "Page"]);
        }
    }
}
