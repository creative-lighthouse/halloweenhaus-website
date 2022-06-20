<?php
namespace App\Team;

use SilverStripe\Admin\ModelAdmin;
/**
 * Class \App\Team\TeamAdmin
 *
 */
class TeamAdmin extends ModelAdmin {

    private static $managed_models = array (
        TeamMember::class,
        Character::class,
    );

    private static $url_segment = "team";

    private static $menu_title = "Team";

    private static $menu_icon = "app/client/icons/team.svg";

    public function init() {
        parent::init();
    }

}
