<?php

namespace App\Wiki;

use PageController;
use SilverStripe\Control\HTTPRequest;

/**
 * Class \App\Wiki\WikiPageController
 *
 * @property WikiPage $dataRecord
 * @method WikiPage data()
 * @mixin WikiPage
 */
class WikiPageController extends PageController
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

    public function character(HTTPRequest $request)
    {
        $characterID = $request->param('ID');
        $character = Character::get()->byID($characterID);
        return [
            'Character' => $character,
        ];
    }

    public function location(HTTPRequest $request)
    {
        $locationID = $request->param('ID');
        $location = Location::get()->byID($locationID);
        return [
            'Location' => $location,
        ];
    }

    public function artefact(HTTPRequest $request)
    {
        $artefactID = $request->param('ID');
        $artefact = Artefact::get()->byID($artefactID);
        return [
            'Artefact' => $artefact,
        ];
    }
}
