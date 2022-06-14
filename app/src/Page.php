<?php

namespace {

    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Forms\DropdownField;

    /**
 * Class \Page
 *
 * @property string $MenuPosition
 * @property int $ElementalAreaID
 * @method \DNADesign\Elemental\Models\ElementalArea ElementalArea()
 * @mixin \DNADesign\Elemental\Extensions\ElementalPageExtension
 */
    class Page extends SiteTree
    {
        private static $db = [
            "MenuPosition" => "Enum('main,footer', 'main')",
        ];

        private static $has_one = [];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();
            $fields->addFieldToTab("Root.Main", new DropdownField("MenuPosition", "Menü", [
                "main" => "Hauptmenü",
                "footer" => "Footer",
            ]), "Content");
            return $fields;
        }

        public function getTimeToHalloween(){
            $date = strtotime("October 31, ".date("Y")." 2:00 PM");
            $remaining = $date - time();
            $days_remaining = floor($remaining / 86400);
            return "Noch $days_remaining Tage bis Halloween";
        }

        public function getNearHalloween(){
            return true;
            $date = strtotime("October 31, ".date("Y")." 2:00 PM");
            $remaining = $date - time();
            $days_remaining = floor($remaining / 86400);
            if($days_remaining < 1){
                return true;
            }
            return false;
        }
    }
}
