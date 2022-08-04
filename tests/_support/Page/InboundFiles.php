<?php

namespace Page;

use AcceptanceTester;
use Exception;

class InboundFiles
{
    private AcceptanceTester $tester;
    /** Sales Files button */
    private const INBOUND_SALES = '#tab-0';
    /** Inventory Files button*/
    private const INVENTORY_FILES = '#tab-2';

    public function __construct(AcceptanceTester $tester)
    {
        $this -> tester = $tester;
    }

    /**
     * @throws Exception
     */
    public function switchToInboundSalesFiles(): void
    {
        $I = $this->tester;
        $I -> waitForElementClickable(self::INBOUND_SALES);
        $I -> clickWithLeftButton(self::INBOUND_SALES);
        $I -> seeInCurrentUrl('inboundSalesFilesTab');
        $I -> wait(10);
    }


    /**
     * @throws Exception
     */
    public function switchToInventoryFiles(): void
    {
        $I = $this->tester;
        $I -> waitForElementClickable(self::INVENTORY_FILES);
        $I -> clickWithLeftButton(self::INVENTORY_FILES);
        $I -> seeInCurrentUrl('inboundInventoryFilesTab');
    }
}
