<?php

namespace App\Shows;

use PageController;
use SilverStripe\Control\HTTPRequest;

/**
 * Class \App\Shows\ShowOverviewPageController
 *
 * @property ShowOverviewPage $dataRecord
 * @method ShowOverviewPage data()
 * @mixin ShowOverviewPage
 */
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

    public function getShows()
    {
        return Show::get()->sort('Year DESC');
    }

    public function getCharacters()
    {
        return Character::get()->sort('SortField ASC');
    }
}
