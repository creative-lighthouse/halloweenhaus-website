<?php

namespace App\Podcast;

use PageController;
use App\Podcast\PodcastEntry;

/**
 * Class \App\Podcast\PodcastPageController
 *
 * @property PodcastPage $dataRecord
 * @method PodcastPage data()
 * @mixin PodcastPage
 */
class PodcastPageController extends PageController
{
    private static $allowed_actions = [
        "view"
    ];

    public function index()
    {
        //return as xml with header
        $this->response->addHeader('Content-Type', 'application/xml');
        return $this->customise([
            'Episodes' => $this->getEpisodes()
        ])->renderWith('App\Podcast\PodcastPage');
    }

    public function view()
    {
        $article = PodcastEntry::get()->byID($this->getRequest()->param("ID"));
        if (!$article) {
            return $this->httpError(404, "That episode could not be found");
        }
        return $this->customise([
            "Episode" => $article
        ])->renderWith("App\Podcast\PodcastEntry");
    }

    public function getEpisodes()
    {
        return PodcastEntry::get()->sort("PublishDate", "DESC");
    }
}
