<?php

namespace App\Elements;

use App\Team\TeamApplicationInterest;
use DNADesign\Elemental\Controllers\ElementController;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Security\SecurityToken;

/**
 * Class \App\Elements\ApplicationElement
 *
 * @property ?string $Text
 * @property ?string $SuccessText
 * @mixin FileLinkTracking
 * @mixin AssetControlExtension
 * @mixin SiteTreeLinkTracking
 * @mixin RecursivePublishable
 * @mixin VersionedStateExtension
 */
class ApplicationElement extends BaseElement
{
    private static $db = [
        "Text" => "HTMLText",
        "SuccessText" => "HTMLText",
    ];

    private static $field_labels = [
        "Text" => "Einleitungstext",
        "SuccessText" => "Erfolgstext (wird nach dem Absenden angezeigt)",
    ];

    private static $table_name = 'ApplicationElement';
    private static $icon = 'sp-icon-job-element';
    private static $controller_class = ElementController::class;

    private ?string $captchaQuestion = null;

    public function getType()
    {
        return "Application Element";
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        return $fields;
    }

    public function getInterests()
    {
        return TeamApplicationInterest::get();
    }

    public function SecurityID(): DBHTMLText
    {
        $token = SecurityToken::inst();
        return DBHTMLText::create()->setValue(sprintf(
            '<input type="hidden" name="%s" value="%s">',
            htmlspecialchars($token->getName()),
            htmlspecialchars($token->getValue())
        ));
    }

    public function CaptchaQuestion(): string
    {
        if ($this->captchaQuestion === null) {
            $a = random_int(1, 10);
            $b = random_int(1, 10);
            Controller::curr()->getRequest()->getSession()->set('CaptchaAnswer', $a + $b);
            $this->captchaQuestion = "{$a} + {$b}";
        }
        return $this->captchaQuestion;
    }

    public function ApplicationError(): ?string
    {
        $session = Controller::curr()->getRequest()->getSession();
        $error = $session->get('ApplicationError');
        if ($error) {
            $session->clear('ApplicationError');
        }
        return $error;
    }
}
