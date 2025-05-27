<?php

namespace App\Events;

use PageController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Security;

/**
 * Class \App\Events\EventAdminPageController
 *
 * @property EventAdminPage $dataRecord
 * @method EventAdminPage data()
 * @mixin EventAdminPage
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
