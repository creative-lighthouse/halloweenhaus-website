<?php

namespace App\Team;

use SilverStripe\ORM\DataObject;

/**
 * Class \App\Team\TeamSocial
 *
 * @property string $Plattform
 * @property string $Link
 * @method \SilverStripe\ORM\ManyManyList|\App\Team\TeamMember[] Members()
 */
class TeamSocial extends DataObject
{
    private static $db = [
        "Plattform" => "Varchar(255)",
        "Link" => "Varchar(255)"
    ];

    private static $many_many = [
        "Members" => TeamMember::class
    ];

    private static $default_sort = "Plattform DESC";

    private static $field_labels = [
        "Plattform" => "Plattform",
        "Link" => "Link",
    ];

    private static $summary_fields = [
        "Plattform" => "Plattform",
        "Link" => "Link",
    ];

    private static $table_name = "TeamSocial";

    private static $singular_name = "Sozialer Link";
    private static $plural_name = "Soziale Links";

    private static $url_segment = "teamsocial";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName("Categories");
        $category_map = [];
        if($categories = TeamMember::get())
        return $fields;
    }

    private static $inline_editable = true;

    public function CMSEditLink()
    {
        $admin = TeamAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }

    public function getFirstCategory()
    {
        return $this->Categories->first();
    }
}
