<?php

namespace App\POS {

    use SilverStripe\AssetAdmin\Forms\UploadField;

    use SilverStripe\Assets\Image;

    use SilverStripe\CMS\Model\SiteTree;

    /**
 * Class \Page
 *
 * @property int $BackgroundImageID
 * @method \SilverStripe\Assets\Image BackgroundImage()
 */
    class POSPage extends SiteTree
    {
        private static $db = [];

        private static $has_one = [
            "BackgroundImage" => Image::class,
        ];

        private static $owns = [
            "BackgroundImage"
        ];

        private static $icon = "app/client/icons/pos_page.svg";
        private static $table_name = "POSPage";

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();
            $fields->addFieldToTab("Root.Main", new UploadField("BackgroundImage", "Hintergrundbild"));
            return $fields;
        }
    }
}
