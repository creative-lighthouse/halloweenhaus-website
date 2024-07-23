<?php
namespace App\Podcast;

use PageController;
use App\Podcast\PodcastEntry;

/**
 * Class \App\Podcast\PodcastPageController
 *
 * @property \App\Podcast\PodcastPage $dataRecord
 * @method \App\Podcast\PodcastPage data()
 * @mixin \App\Podcast\PodcastPage
 */
class PodcastPageController extends PageController
{
    private static $allowed_actions = [
    ];

    public function getEpisodes()
    {
        return PodcastEntry::get()->sort("PublishDate", "DESC");
    }
}
