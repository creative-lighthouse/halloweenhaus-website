<?php
namespace App\Feedback;

use PageController;
use App\Feedback\FeedbackEntry;
use SilverStripe\Control\HTTPRequest;

/**
 * Class \App\Team\TeamOverviewController
 *
 * @property \App\Feedback\FeedbackPage $dataRecord
 * @method \App\Feedback\FeedbackPage data()
 * @mixin \App\Feedback\FeedbackPage
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
}
