<?php

namespace Page;

use AcceptanceTester;
use Exception;

class Products
{
    private AcceptanceTester $tester;

    /** Add new product button */
    private const NEW_PRODUCT = '.el-icon-plus';
    /** New product name */
    private const NEW_PRODUCT_NAME = '[name="name"]';

    public function __construct(AcceptanceTester $tester)
    {
        $this->tester = $tester;
    }

    /**
     * @throws Exception
     */
    public function createNewProduct():void
    {
        $I = $this ->tester;
        $I -> clickWithLeftButton(self::NEW_PRODUCT);
        $I -> seeElement(self::NEW_PRODUCT_NAME);
        $I -> fillField(self::NEW_PRODUCT_NAME, 'test');
    }

}