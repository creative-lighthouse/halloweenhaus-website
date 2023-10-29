<?php

namespace App\Events;

use App\Utilities\PdfHelper;
use Nesk\Puphpeteer\Puppeteer;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Control\Email\Email;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\SSViewer;

/**
 * Class \App\Events\EmailNotification
 *
 * @property string $Title
 * @property string $Text
 * @property string $Email
 * @property string $Type
 * @property int $EventID
 * @property int $RegistrationID
 * @method \App\Events\Event Event()
 * @method \App\Events\Registration Registration()
 */
class EmailNotification extends DataObject
{

    private static $db = array(
        "Title" => "Varchar(512)",
        "Text" => "Varchar(1023)",
        "Email" => "Varchar(255)",
        "Type" => "Varchar(255)",
    );
    private static $has_one = array(
        "Event" => Event::class,
        "Registration" => Registration::class,
    );

    private static $summary_fields = array(
        "Event.Title" => "Veranstaltung",
        "Registration.Title" => "Empfänger",
        "Email" => "Email-Adresse",
        "Created" => "Datum",
        "Title" => "Betreff",
    );

    private static $default_sort = "Created DESC";

    private static $field_labels = array(
        "Title" => "Betreff",
        "Text" => "Text",
        "Email" => "Email-Adresse",
        "Event" => "Veranstaltung",
    );

    private static $table_name = "email_notification";

    private static $singular_name = "Email Benachrichtigung";
    private static $plural_name = "Email Benachrichtigungen";

    private static $searchable_fields = array(
        "Title",
        "Event.Title",
        "Email",
        "Registration.Title",
    );

    function getCMSFields()
    {
        $fields = parent::getCMSFields();

        return $fields;
    }

    function onBeforeWrite()
    {
        parent::onBeforeWrite();
    }

    function onAfterWrite()
    {
        parent::onAfterWrite();

        if ($this->Email) {
            $registration = $this->Registration();
            $this->Email = strtolower($this->Email);
            $email = Email::create()
                ->setHTMLTemplate('emails/EventEmail')
                ->setPlainTemplate('emails/EventEmailPlain')
                ->setData([
                    "Registration" => $registration,
                    "Subject" => $this->Title,
                    "Text" => DBField::create_field('HTMLText', $this->Text)
                ])
                ->setFrom("events@halloweenhaus-schmalenbeck.de", "Halloweenhaus Schmalenbeck")
                ->setTo($this->Email)
                ->setSubject(SSViewer::execute_string($this->Title, $this->Event()));
            $email->send();
        }
    }

    function getDateFormatted()
    {
        if ($this->Created) {
            return $this->dbObject("Created")->Format("dd.MM.yyyy HH:mm");
        }
    }
}
