<?php

namespace acceptance;
use Page\Auth;
use Page\InboundFillesForms\InboundSales;
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

    public function uploadSalesFile(
        Auth $auth,
        Main $main,
        InboundFiles $inboundFiles,
        InboundSales $inboundSales
    ):void
    {
        $auth -> login();
        $main -> goToDso();
        $main -> goToInboundFiles();
        $inboundFiles -> switchToInboundSalesFiles();
        $inboundSales ->aploadFile();
    }
}