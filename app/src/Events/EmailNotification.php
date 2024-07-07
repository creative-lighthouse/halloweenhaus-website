<?php

namespace App\Events;

use App\Utilities\PdfHelper;
use Nesk\Puphpeteer\Puppeteer;
use SilverStripe\View\SSViewer;
use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Director;
use Colymba\BulkManager\BulkManager;
use SilverStripe\Assets\File;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Control\Email\Email;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBBoolean;

/**
 * Class \App\Events\EmailNotification
 *
 * @property string $Title
 * @property string $Text
 * @property string $Email
 * @property string $Type
 * @property int $EventID
 * @property int $RegistrationID
 * @property int $AttachmentID
 * @method \App\Events\Event Event()
 * @method \App\Events\Registration Registration()
 * @method \SilverStripe\Assets\File Attachment()
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
        "Attachment" => File::class,
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

        $registration = $this->Registration();
        $this->Email = strtolower($this->Email);

        if ($this->Email != "test@test.de") {
            $email = Email::create('events@halloweenhaus-schmalenbeck.de', $this->Email, 'Deine Anmeldung');
            $email->html($this->Text);
            $email->text($this->Text);
            //if ($this->Attachment()) {
            //    $email->addAttachment($this->Attachment());
            //}
            $email->setHTMLTemplate('emails/EventEmail');
            $email->setPlainTemplate('emails/EventEmailPlain');
            $email->setSubject($this->Title);
            $email->setData([
                "Registration" => $registration,
                "Subject" => $this->Title,
                "Text" => DBField::create_field('HTMLText', $this->Text)
            ]);
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
