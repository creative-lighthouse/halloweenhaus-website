<?php
namespace App\Team;

use PageController;

/**
 * Class \App\Team\TeamOverviewController
 *
 * @property \App\Team\TeamOverview dataRecord
 * @method \App\Team\TeamOverview data()
 * @mixin \App\Team\TeamOverview
 */
class TeamOverviewController extends PageController
{

    private static $allowed_actions = [
        "view",
    ];

    public function view()
    {
        $id = $this->getRequest()->param("ID");
        $exploded = explode("-", $id);
        $article = TeamMember::get()->filter("ID", $exploded[0])->first();
        return array(
            "TeamMember" => $article,
        );
    }

    public function getTeamMembers()
    {
        return TeamMember::get();
    }
}
