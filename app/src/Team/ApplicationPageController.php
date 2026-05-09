<?php

namespace App\Team;

use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\View\Requirements;
use SilverStripe\Security\SecurityToken;

/**
 * Controller for team application page
 *
 */
class ApplicationPageController extends Controller
{
    private static $allowed_actions = [
        'index',
        'erfolgreich',
        'submit',
    ];

    private static $url_segment = 'bewerbung';

    /**
     * Display the application form
     */
    public function index(HTTPRequest $request)
    {
        $data = [
            'Title' => 'Bewerbung - Team Halloweenhaus',
            'MetaTitle' => 'Bewerbung',
        ];

        // Check if form was submitted successfully
        if ($request->getSession()->get('ApplicationSubmitted')) {
            $data['Success'] = true;
            $request->getSession()->clear('ApplicationSubmitted');
        }

        // Check for errors
        if ($error = $request->getSession()->get('ApplicationError')) {
            $data['Error'] = $error;
            $request->getSession()->clear('ApplicationError');
        }

        return $this->customise($data)->renderWith(['App/Team/ApplicationPage', 'Page']);
    }

    public function erfolgreich(HTTPRequest $request)
    {
        $data = [
            'Title' => 'Bewerbung erfolgreich - Team Ottos Halloweenhaus',
            'MetaTitle' => 'Bewerbung erfolgreich',
        ];

        return $this->customise($data)->renderWith(['App/Team/ApplicationPage_erfolgreich', 'Page']);
    }

    /**
     * Handle form submission
     */
    public function submit(HTTPRequest $request)
    {
        // Only allow POST requests
        if (!$request->isPOST()) {
            return $this->httpError(405, 'Method not allowed');
        }

        // Check security token
        if (!SecurityToken::inst()->checkRequest($request)) {
            return $this->httpError(403, 'Invalid security token');
        }

        // Get form data
        $data = $request->postVars();

        // Basic validation
        if (empty($data['Title']) || empty($data['Email']) || empty($data['Birthday'])) {
            $request->getSession()->set('ApplicationError', 'Bitte fülle alle Pflichtfelder aus.');
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
        $request->getSession()->set('ApplicationSubmitted', true);

        // Redirect back to application page
        return $this->redirect('/bewerbung/erfolgreich');
    }

    /**
     * Get all available interests
     */
    public function getInterests()
    {
        return TeamApplicationInterest::get();
    }

    /**
     * Get security token
     */
    public function getSecurityToken()
    {
        return SecurityToken::inst();
    }

    /**
     * Get the link to this controller
     */
    public function Link($action = null)
    {
        return Controller::join_links('/bewerbung', $action);
    }
}
