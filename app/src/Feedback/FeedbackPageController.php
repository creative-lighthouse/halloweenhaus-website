<?php

namespace App\Feedback;

use PageController;
use App\Events\Event;
use App\Feedback\FeedbackEntry;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Model\List\GroupedList;

/**
 * Class \App\Feedback\FeedbackPageController
 *
 * @property FeedbackPage $dataRecord
 * @method FeedbackPage data()
 * @mixin FeedbackPage
 */
class FeedbackPageController extends PageController
{

    private static $allowed_actions = [
        "sendfeedback",
        "thanks",
    ];

    public function sendfeedback(HTTPRequest $request)
    {
        if (!$request->isPOST()) {
            return $this->redirectBack();
        }
        $feedback = FeedbackEntry::create();
        $feedback->Day = $request->postVar("day");
        $feedback->Stars = $request->postVar("rating");
        $feedback->Comment = $request->postVar("comment");
        $feedback->PLZ = $request->postVar("plz");
        $feedback->write();
        return $this->redirect($this->Link("thanks"));
    }

    public function thanks()
    {
        return [];
    }

    public function getEventDates()
    {
        $currentYear = date("Y");
        $eventsThisYear = Event::get()->filter("EventDate:GreaterThan", "{$currentYear}-01-01 00:00:00")->sort("EventDate ASC, StartTime ASC");
        $eventsThisYear = $eventsThisYear->filter("Visible", true);
        return GroupedList::create($eventsThisYear);
    }
}
