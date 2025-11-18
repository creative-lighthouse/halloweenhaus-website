<?php

namespace App\Shows;

use PageController;
use SilverStripe\Control\HTTPRequest;

class ShowOverviewPageController extends PageController
{

    private static $allowed_actions = [
        'index'
    ];

    public function index(HTTPRequest $request)
    {
        return array(
        );
    }
}
