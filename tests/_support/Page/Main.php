<?php

namespace Page;

use AcceptanceTester;
use Exception;

class Main
{
    private AcceptanceTester $tester;

    /** CLM button */
    private const CLM_BUTTON = 'header > div:nth-child(2) > div > button > span';
    /** DSO button */
    private const DSO_BUTTON = 'header > div:nth-child(2) > div > button > span';
    /** Product button */
    private const PRODUCT_BUTTON = '//div[2]/div/a[1]/button/span';
    /** Posting button */
    private const POSTING_BUTTON = 'div:nth-child(2) > div > a:nth-child(11) > button > span';
    /** Inbound Files button */
    private const INBOUND_FILES = 'div:nth-child(2) > div > a:nth-child(9) > button > span';
    /** Product button */


    public function __construct(AcceptanceTester $tester)
    {
        $this->tester = $tester;
    }

    /**
     * Переход в InboundSales
     *
     * @throws Exception
     */
    public function goToDso(): void
    {
        $I = $this->tester;
        $I->clickWithLeftButton(self::DSO_BUTTON);
        $I->seeElement(self::PRODUCT_BUTTON);
        $I->seeElement(self::POSTING_BUTTON);
    }

    /**
     * Go to Inbound files page
     * @throws Exception
     */
    public function goToInboundFiles(): void
    {
        $I = $this->tester;
        $I -> clickWithLeftButton(self::INBOUND_FILES);
        $I -> seeInCurrentUrl('inboundFiles');
    }

    /**
     * Go to Product page
     * @throws Exception
     */
    public function goToProductPage():void
    {
        $I = $this->tester;
        $I -> clickWithLeftButton(self::PRODUCT_BUTTON);
        $I -> seeInCurrentUrl('products');
    }
}