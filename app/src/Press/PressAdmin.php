<?php

namespace App\Press;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

/**
 * Class \App\Press\PressAdmin
 *
 */
class PressAdmin extends ModelAdmin
{

    private static $managed_models = array(
        PressImage::class,
    );

    private static $url_segment = "press";

    private static $menu_title = "Presse";

    private static $menu_icon = "app/client/icons/press_admin.svg";

    public function init()
    {
        parent::init();
    }

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        //This check is simply to ensure you are on the managed model you want adjust accordingly
        $gridField = $form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass));

        // This is just a precaution to ensure we got a GridField from dataFieldByName() which you should have
        if ($gridField instanceof GridField) {
            $gridField->getConfig()->addComponent(GridFieldSortableRows::create('SortField'));
        }

        return $form;
    }
}
