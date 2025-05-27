<?php

namespace App\Elements;

use App\Events\Event;
use DNADesign\Elemental\Models\BaseElement;

/**
 * Class \App\Elements\TimelineElement
 *
 * @property string $Content
 */
class EventsElement extends BaseElement
{

    private static $db = [
        "Content" => "HTMLText",
    ];

    private static $table_name = 'EventsElement';
    private static $icon = 'font-icon-circle-star';

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Eventliste');
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }

    public function getEvents()
    {
        return Event::get()->filter("StartTime:GreaterThan", date("Y-m-d H:i:s"))->sort("StartTime ASC");
    }
}
