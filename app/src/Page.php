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

        function daysTillHalloween()
        {
            //Today's date.
            $today = new DateTime();

            //Halloween.
            $halloweenDay = date("Y") . "-10-31";

            //Have we already passed this year's Halloween?
            if (date("m") > 10) {
                //Use next year's Halloween date.
                $halloweenDay = (date("Y") + 1) . "-10-31";
            }

            //Create DateTime object for Christmas Day.
            $halloweenDay = new DateTime($halloweenDay);

            //Get the interval difference between the two dates.
            $interval = $today->diff($halloweenDay);

            //Print out the number of days between
            //now and the next Halloween.
            return $interval->days;
        }

        public function getNearHalloween()
        {
            $remaining = $this->daysTillHalloween();
            if ($remaining < 1) {
                return true;
            }
            return false;
        }

        public function visibleInMenu($urlSegment)
        {
            $page = Page::get()->filter('URLSegment', $urlSegment)->first();
            return $page ? $page->ShowInMenus : false;
        }
    }
}
