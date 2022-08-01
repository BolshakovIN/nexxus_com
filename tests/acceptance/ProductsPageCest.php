<?php

namespace acceptance;
use Page\Auth;
use Page\Main;
use Page\Products;


class ProductsPageCest
{
    /** Create new product
     * @throws \Exception
     */
    public function createNewProduct(
        Auth $auth,
        Main $main,
        Products $products
    ):void
    {
        $auth -> login();
        $main -> goToDso();
        $products -> createNewProduct();
    }
}