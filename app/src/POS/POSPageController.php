<?php

namespace App\POS {

    use SilverStripe\Control\HTTPRequest;
    use SilverStripe\CMS\Controllers\ContentController;

    /**
 * Class \PageController
 *
 * @property \App\POS\POSPage $dataRecord
 * @method \App\POS\POSPage data()
 * @mixin \App\POS\POSPage
 */
    class POSPageController extends ContentController
    {
        private static $allowed_actions = [];

        public function index(HTTPRequest $request)
        {
            $products = Product::get();
            $sales = Sale::get();

            return $this->customise([
                "Products" => $products,
                "Sales" => $sales
            ])->renderWith(["App/POS/POSPage"]);
        }

        public function getProducts()
        {
            $products = Product::get();
            return $products;
        }
    }
}
