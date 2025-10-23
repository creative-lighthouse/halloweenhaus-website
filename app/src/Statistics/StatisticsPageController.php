<?php

namespace App\Statistics;

use App\Events\EntryLog;
use App\Events\Registration;
use App\Feedback\FeedbackEntry;
use PageController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Model\List\GroupedList;
use SilverStripe\Model\ArrayData;
use SilverStripe\Model\List\ArrayList;
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

    

    public function getOriginRegistrationThisYear(){
        $currentYear = date('Y');
        $startOfYear = date('Y-01-01 00:00:00', strtotime($currentYear.'-01-01'));
        $endOfYear = date('Y-12-31 23:59:59', strtotime($currentYear.'-12-31'));
        $registrations = Registration::get()->filter([
            'Created:GreaterThanOrEqual' => $startOfYear,
            'Created:LessThanOrEqual' => $endOfYear
        ]);
        $registrations = $registrations->sort(['ZIP' => 'ASC']);
        $grouped = [];
        foreach($registrations as $registration){
            $plz = $registration->ZIP;
            if(!isset($grouped[$plz])){
                $grouped[$plz] = 0;
            }
            $grouped[$plz] += $registration->GroupSize;
        }

        arsort($grouped);
        $result = [];
        foreach ($grouped as $zip => $count) {
            $result[] = ArrayData::create([
                'ZIP' => $zip,
                'Number' => $count
            ]);
        }
        return ArrayList::create($result);
    }

    public function getOriginFeedbackThisYear(){
        $currentYear = date('Y');
        $startOfYear = date('Y-01-01 00:00:00', strtotime($currentYear.'-01-01'));
        $endOfYear = date('Y-12-31 23:59:59', strtotime($currentYear.'-12-31'));
        $feedbacks = FeedbackEntry::get()->filter([
            'Created:GreaterThanOrEqual' => $startOfYear,
            'Created:LessThanOrEqual' => $endOfYear
        ]);
        $feedbacks = $feedbacks->sort(['PLZ' => 'ASC']);
        $grouped = [];
        foreach($feedbacks as $feedback){
            $plz = $feedback->PLZ;
            if(!isset($grouped[$plz])){
                $grouped[$plz] = 0;
            }
            $grouped[$plz] ++;
        }

        arsort($grouped);
        $result = [];
        foreach ($grouped as $zip => $count) {
            $result[] = ArrayData::create([
                'ZIP' => $zip,
                'Number' => $count
            ]);
        }
        return ArrayList::create($result);
    }

    public function getRatingPerDay() {
        $currentYear = date('Y');
        $startOfYear = date('Y-01-01 00:00:00', strtotime($currentYear . '-01-01'));
        $endOfYear = date('Y-12-31 23:59:59', strtotime($currentYear . '-12-31'));
        $feedbacks = FeedbackEntry::get()->filter([
            'Created:GreaterThanOrEqual' => $startOfYear,
            'Created:LessThanOrEqual' => $endOfYear
        ]);

        $days = [];
        foreach ($feedbacks as $f) {
            $d = $f->Day;
            if (!isset($days[$d])) $days[$d] = ['stars' => 0, 'count' => 0];
            $days[$d]['stars'] += $f->Stars;
            $days[$d]['count']++;
        }

        krsort($days);

        $result = [];
        foreach ($days as $d => $v) {
            $result[] = ArrayData::create([
                'Day' => date('d.m.Y', strtotime($d)),
                'AverageStars' => $v['count'] ? round($v['stars'] / $v['count'], 2) : 0,
                'Count' => $v['count']
            ]);
        }
        return ArrayList::create($result);
    }

    public function getFeedbackComments() {
        $currentYear = date('Y');
        $startOfYear = date('Y-01-01 00:00:00', strtotime($currentYear.'-01-01'));
        $endOfYear = date('Y-12-31 23:59:59', strtotime($currentYear.'-12-31'));
        $feedbacks = FeedbackEntry::get()->filter([
            'Created:GreaterThanOrEqual' => $startOfYear,
            'Created:LessThanOrEqual' => $endOfYear,
            'Comment:Not' => ['', null]
        ])->sort('Created', 'DESC');

        return $feedbacks;
    }
}
