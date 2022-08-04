<?php

namespace acceptance;

use Page\APImethods;
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
    ): void {
        $auth -> login();
        $main -> goToDso();
        $main -> goToProductPage();
        $products -> createNewProduct();
    }

    public function goToDB(
        APImethods $APImethods
    ): void {
        $APImethods ->getUser('98261111');
    }
}
