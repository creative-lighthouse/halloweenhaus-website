<?php

namespace App\Podcast;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

/**
 * Class \App\Podcast\PodcastEntry
 *
 * @property string $Title
 * @property int $Episode
 * @property int $Season
 * @property string $Description
 * @property string $PublishDate
 * @property bool $Explicit
 * @property string $Hash
 * @property int $AudioID
 * @method \SilverStripe\Assets\File Audio()
 */
class PodcastEntry extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Episode" => "Int",
        "Season" => "Int",
        "Description" => "HTMLText",
        "PublishDate" => "Datetime",
        "Explicit" => "Boolean",
        "Hash" => "Varchar(255)"
    ];

    private static $has_one = [
        "Audio" => File::class
    ];

    private static $owns = [
        "Audio"
    ];

    private static $default_sort = "PublishDate DESC, Title ASC";

    private static $field_labels = [

    ];

    private static $summary_fields = [
        "Season",
        "Episode",
        "Title",
        "PublishDate",
    ];

    private static $searchable_fields = [
        "Title", "Description", "Season", "Episode", "PublishDate"
    ];

    private static $table_name = "PodcastEntry";

    private static $singular_name = "Podcast-Folge";
    private static $plural_name = "Podcast-Folgen";

    private static $url_segment = "podcastentry";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = PodcastAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }

    public function ExplicitFormatted()
    {
        return $this->Explicit ? "true" : "false";
    }
}
