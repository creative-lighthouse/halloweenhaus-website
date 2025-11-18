<?php

namespace App\Shows;

use App\Shows\Show;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class \App\Shows\ShowAdmin
 *
 */
class ShowAdmin extends ModelAdmin
{
    private static $managed_models = array(
        Show::class,
        Character::class,
    );

    private static $url_segment = "shows";

    private static $menu_title = "Shows & Historie";

    private static $menu_icon = "app/client/icons/show_admin.svg";

    public function init()
    {
        parent::init();
    }

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        // This check is simply to ensure you are on the managed model you want adjust accordingly
        $gridField = $form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass));

        // This is just a precaution to ensure we got a GridField from dataFieldByName() which you should have
        if ($gridField instanceof GridField) {
            //Check if managed model is Character to add the SortableRows component
            if (!$this->modelClass === Show::class) {
                $gridField->getConfig()->addComponent(GridFieldOrderableRows::create('SortField'));
            }

        }

        return $form;
    }
}
