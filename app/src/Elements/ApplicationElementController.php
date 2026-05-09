<?php

namespace App\Elements;

use App\Team\TeamApplication;
use DNADesign\Elemental\Controllers\ElementController;
use SilverStripe\Control\HTTPRequest;

/**
 * Class \App\Elements\ApplicationElementController
 *
 */
class ApplicationElementController extends ElementController
{
    private static $allowed_actions = [
        'submitApplication',
    ];

    /**
     * Handle form submission
     */
    public function submitApplication(HTTPRequest $request)
    {
        // Only allow POST requests
        if (!$request->isPOST()) {
            return $this->httpError(405, 'Method not allowed');
        }

        // Get form data
        $data = $request->postVars();

        // Basic validation
        if (empty($data['Title']) || empty($data['Email']) || empty($data['Birthday'])) {
            $this->getRequest()->getSession()->set('ApplicationError', 'Bitte fülle alle Pflichtfelder aus.');
            return $this->redirectBack();
        }

        // Create new application
        $application = TeamApplication::create();
        $application->Title = $data['Title'] ?? '';
        $application->Birthday = $data['Birthday'] ?? '';
        $application->Email = $data['Email'] ?? '';
        $application->Hobbies = $data['Hobbies'] ?? '';
        $application->ReasonToJoin = $data['ReasonToJoin'] ?? '';
        $application->Status = 'new';
        $application->write();

        // Handle interests (many_many relationship)
        if (isset($data['Interests']) && is_array($data['Interests'])) {
            $application->Interests()->setByIDList($data['Interests']);
        }

        // Store success message in session
        $this->getRequest()->getSession()->set('ApplicationSubmitted', true);

        // Redirect back to the same page
        return $this->redirectBack();
    }

    /**
     * Check if application was successfully submitted
     */
    public function ApplicationSubmitted()
    {
        $session = $this->getRequest()->getSession();
        $submitted = $session->get('ApplicationSubmitted');

        // Clear the flag after reading it
        if ($submitted) {
            $session->clear('ApplicationSubmitted');
        }

        return $submitted;
    }

    /**
     * Get error message if any
     */
    public function ApplicationError()
    {
        $session = $this->getRequest()->getSession();
        $error = $session->get('ApplicationError');

        // Clear the error after reading it
        if ($error) {
            $session->clear('ApplicationError');
        }

        return $error;
    }
}
