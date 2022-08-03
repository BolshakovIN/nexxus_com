<?php

namespace Page;

use AcceptanceTester;
use Exception;

/** страница Products */
class Products
{
    private AcceptanceTester $tester;

    /** Add new product button */
    private const NEW_PRODUCT = '.el-icon-plus';
    /** New product name button*/
    private const NEW_PRODUCT_NAME_FIELD = '[name="name"]';
    /** Nexxus category name field*/
    private const CATEGORY_NAME_BUTTON = '[name="nexxusCategoryId"]';
    /** Nexxus subcategory name button */
    private const SUBCATEGORY_NAME_BUTTON = '[name="nexxusSubcategoryId"]';
    /** Choose type IDS button*/
    private const TYPE_IDS_BUTTON = '[name="nextId"]';
    /** Global ID name field*/
    private const GLOBAL_ID_NAME_FIELD = '[name="ids0IdentifierId"]';
    /** Global ID value field */
    private const GLOBAL_ID_VALUE_FIELD = '[name="ids0Value"]';

    /** Books category */
    private const BOOKS_CATEGORY_NAME = '//div[2]/div/div/div[2]/div[1]/div[1]/ul/li[3]/span';
    /** Books subcategory */
    private const BOOKS_SUB_CATEGORY_NAME = '//div[3]/div/div[1]/div[2]/div[1]/div[1]/ul/li[1]';
    /** Clobal Type IDS */
    private const GLOBAL_TYPE_IDS_NAME = '//*[@id="ids"]/div/form/div[1]/div/div/div[2]/div[1]/div[1]/ul/li[1]/span';
    /** Chose UPC */
    private const UPC_TYPE = '//*[@id="ids"]/div/div/div/div/div[1]/div/div[1]/div[2]/div[1]/div[1]/ul/li[2]/span';
    /** Create */
    private const CREATE = '//div[9]/div/div/span/div[2]/button';
    /** UPC */

    public function __construct(AcceptanceTester $tester)
    {
        $this->tester = $tester;
    }

    /**
     * создание нового продукта
     * @throws Exception
     */
    public function createNewProduct():void
    {
        $I = $this ->tester;
        $upc = mt_rand(9000000000000,10000000000000);
        $I -> clickWithLeftButton(self::NEW_PRODUCT);
        $I -> waitForElementClickable(self::NEW_PRODUCT_NAME_FIELD);
        $I -> seeElement(self::NEW_PRODUCT_NAME_FIELD);
        // name product
        $I -> fillField(self::NEW_PRODUCT_NAME_FIELD, 'test');
        //category product
        $I -> clickWithLeftButton(self::CATEGORY_NAME_BUTTON);
        $I -> clickWithLeftButton(self::BOOKS_CATEGORY_NAME);
        //subcategory product
        $I -> waitForElementClickable(self::SUBCATEGORY_NAME_BUTTON);
        $I -> clickWithLeftButton(self::SUBCATEGORY_NAME_BUTTON);
        $I -> waitForElementClickable(self::BOOKS_SUB_CATEGORY_NAME);
        $I -> clickWithLeftButton(self::BOOKS_SUB_CATEGORY_NAME);
        // type IDs
        $I -> clickWithLeftButton(self::TYPE_IDS_BUTTON);
        $I -> clickWithLeftButton(self::GLOBAL_TYPE_IDS_NAME);
        //global ID type
        $I -> waitForElementClickable(self::GLOBAL_ID_NAME_FIELD);
        $I -> clickWithLeftButton(self::GLOBAL_ID_NAME_FIELD);
        $I -> clickWithLeftButton(self::UPC_TYPE);
        $I->wait(2);
        $I -> clickWithLeftButton(self::GLOBAL_ID_VALUE_FIELD);
        $I -> wait(5);
        $I -> fillField(self::GLOBAL_ID_VALUE_FIELD, $upc);
    }
}