<?php

namespace {

    use App\Statistics\PageStatisticsDay;

    use SilverStripe\CMS\Controllers\ContentController;

    /**
     * Class \PageController
     *
     * @property Page $dataRecord
     * @method Page data()
     */
    class PageController extends ContentController
    {
        private static $allowed_actions = [];

        protected function init()
        {
            parent::init();

            //Increment page view for this page for today
            //PageStatisticsDay::incrementPageViewForPage($this->dataRecord);
        }
    }
}
