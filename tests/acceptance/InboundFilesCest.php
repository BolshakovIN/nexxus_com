<?php

namespace acceptance;
use Page\Auth;
use Page\Main;
use Page\InboundFiles;


class InboundFilesCest
{
    /** Переход в Sales Files
     * @throws \Exception
     */
    public function goToSalesFiles(
        Main $main,
        Auth $auth,
        InboundFiles $inboundFiles
    ):void
    {
        $auth -> login();
        $main -> goToDso();
        $main -> goToInboundFiles();
        $inboundFiles -> switchToInboundSalesFiles();
    }

    /**Переход в Inventory Files
     * @throws \Exception
     */
    public function goToInventoryFiles(
        Auth $auth,
        Main $main,
        InboundFiles $inboundFiles
    ):void
    {
        $auth -> login();
        $main -> goToDso();
        $main -> goToInboundFiles();
        $inboundFiles -> switchToInventoryFiles();
    }
}