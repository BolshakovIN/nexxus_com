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
    private const PRODUCT_BUTTON = 'div:nth-child(2) > div > a:nth-child(2) > button > span';
    /** Posting button */
    private const POSTING_BUTTON = 'div:nth-child(2) > div > a:nth-child(11) > button > span';
    /** Inbound Files bitton */
    private const INBOUND_FILES = 'div:nth-child(2) > div > a:nth-child(9) > button > span';
    /** Sales Files button */
    private const INBOUND_SALES = '#tab-0';

    public function __construct(AcceptanceTester $tester)
        {
            $this -> tester = $tester;
        }

    /**
     * Переход в InboundSales
     *
     * @throws Exception
     */
    public function goToDso():void
    {
        $I = $this->tester;
        $I -> clickWithLeftButton(self::DSO_BUTTON);
        $I -> seeElement(self::PRODUCT_BUTTON);
        $I -> seeElement(self::POSTING_BUTTON);
    }

    /**
     * @throws Exception
     */
    public function switchToInboundSalesFiles():void
    {
        $I = $this->tester;
        $I -> clickWithLeftButton(self::INBOUND_FILES);
        $I -> waitForElementClickable(self::INBOUND_SALES);
        $I -> clickWithLeftButton(self::INBOUND_SALES);
        $I -> wait(10);
    }
}