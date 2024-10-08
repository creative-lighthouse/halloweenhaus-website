<?php

namespace App\ImageBooth;

use PageController;
use App\ImageBooth\BoothImage;
use SilverStripe\Security\Security;
use SilverStripe\Control\HTTPRequest;

/**
 * Class \App\Team\TeamOverviewController
 *
 * @property \App\ImageBooth\PhotoboxGalleryPage $dataRecord
 * @method \App\ImageBooth\PhotoboxGalleryPage data()
 * @mixin \App\ImageBooth\PhotoboxGalleryPage
 */
class PhotoboxGalleryPageController extends PageController
{

    private static $allowed_actions = [
        "foto",
    ];

    public function index(HTTPRequest $request)
    {
        $currentuser = Security::getCurrentUser();
        $boothImages = BoothImage::get()->filter("isVisible", true)->sort("Created", "DESC");

        return array(
            "BoothImages" => $boothImages,
        );
    }

    public function foto(HTTPRequest $request)
    {
        $id = $request->param("ID");
        $boothImage = BoothImage::get()->byID($id);

        return array(
            "BoothImage" => $boothImage,
        );
    }
}
