<?php

namespace App\FleaMarket;

use App\FleaMarket\FleaMarketProduct;
use SilverStripe\Control\HTTPRequest;
use App\FleaMarket\FleaMarketProductCategory;
use PageController;

/**
 * Class \App\FleaMarket\FleaMarketPageController
 *
 * @property FleaMarketPage $dataRecord
 * @method FleaMarketPage data()
 * @mixin FleaMarketPage
 */
class FleaMarketPageController extends PageController
{
    private static $allowed_actions = [
        "view",
        "category",
    ];

    protected function init()
    {
        parent::init();
    }

    public function view(HTTPRequest $request)
    {
        $product = FleaMarketProduct::get()->byID($request->param("ID"));
        if (!$product) {
            return $this->httpError(404, "Produkt nicht gefunden");
        }

        return array(
            "Title" => $product->Title,
            "Product" => $product,
        );
    }

    public function category(HTTPRequest $request)
    {
        $category = FleaMarketProductCategory::get()->byID($request->param("ID"));
        if (!$category) {
            return $this->httpError(404, "Kategorie nicht gefunden");
        }

        return array(
            "Title" => $category->Title,
            "Category" => $category,
        );
    }

    public function getProducts()
    {
        //Filter Products by visibility
        return FleaMarketProduct::get()->filter("Visible", true);
    }

    public function getCategories()
    {
        return FleaMarketProductCategory::get();
    }
}
