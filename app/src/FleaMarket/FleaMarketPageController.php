<?php

namespace App\FleaMarket;

use App\FleaMarket\FleaMarketProduct;
use SilverStripe\Control\HTTPRequest;
use App\FleaMarket\FleaMarketProductCategory;
use SilverStripe\CMS\Controllers\ContentController;

/**
 * Class \App\FleaMarket\FleaMarketPageController
 *
 * @property \App\FleaMarket\FleaMarketPage $dataRecord
 * @method \App\FleaMarket\FleaMarketPage data()
 * @mixin \App\FleaMarket\FleaMarketPage
 */
class FleaMarketPageController extends ContentController
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
