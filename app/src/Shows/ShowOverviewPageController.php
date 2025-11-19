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
        'index',
        'show',
        'character',
        'location',
        'artefact',
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

    public function getLocations()
    {
        return Location::get()->sort('SortField ASC');
    }

    public function getArtefacts()
    {
        return Artefact::get()->sort('SortField ASC');
    }

    public function show(HTTPRequest $request)
    {
        $showID = $request->param('ID');
        $show = Show::get()->byID($showID);
        return [
            'Show' => $show,
        ];
    }
}
