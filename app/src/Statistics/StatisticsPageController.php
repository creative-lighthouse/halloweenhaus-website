<?php

namespace App\Statistics;

use App\Events\EntryLog;
use PageController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Model\List\GroupedList;
use SilverStripe\Security\Security;

/**
 * Class \App\Statistics\StatisticsPageController
 *
 * @property StatisticsPage $dataRecord
 * @method StatisticsPage data()
 * @mixin StatisticsPage
 */
class StatisticsPageController extends PageController
{

    private static $allowed_actions = [
        'index'
    ];

    public function index(HTTPRequest $request)
    {
        $currentUser = Security::getCurrentUser();
        /*if (!$currentUser) {
            return $this->redirect("/login");
        }*/
        return array(
            'TotalGuestCountThisYear' => $this->getTotalGuestCountThisYear(),
            'VQGuestCountThisYear' => $this->getVQGuestCountThisYear(),
            'SQGuestCountThisYear' => $this->getSQGuestCountThisYear(),
            'GroupedEntryLogs' => $this->getGroupedEntryLogs(),
        );
    }

    public function getTotalGuestCountThisYear()
    {
        $currentYear = date("Y");
        //Count VQ as row in EntryLog
        $guestCount = EntryLog::get()->filter([
            "EntryTime:GreaterThanOrEqual" => date("Y-m-d H:i:s", strtotime("first day of January $currentYear")),
        ])->sum("VQ");
        //Count SQ as row in EntryLog
        $guestCount += EntryLog::get()->filter([
            "EntryTime:GreaterThanOrEqual" => date("Y-m-d H:i:s", strtotime("first day of January $currentYear")),
        ])->sum("SQ");
        return $guestCount;
    }

    public function getVQGuestCountThisYear()
    {
        $currentYear = date("Y");
        //Count VQ as row in EntryLog
        $guestCount = EntryLog::get()->filter([
            "EntryTime:GreaterThanOrEqual" => date("Y-m-d H:i:s", strtotime("first day of January $currentYear")),
        ])->sum("VQ");
        return $guestCount;
    }

    public function getSQGuestCountThisYear()
    {
        $currentYear = date("Y");
        //Count VQ as row in EntryLog
        $guestCount = EntryLog::get()->filter([
            "EntryTime:GreaterThanOrEqual" => date("Y-m-d H:i:s", strtotime("first day of January $currentYear")),
        ])->sum("SQ");
        return $guestCount;
    }

    public function getGroupedEntryLogs()
    {
        $groupedList = GroupedList::create(EntryLog::get());
        return $groupedList;
    }
}
