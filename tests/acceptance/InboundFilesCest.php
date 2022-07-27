<?php

namespace acceptance;
use Page\Auth;
use Page\Main;

class InboundFilesCest
{
    /** Переход в InboundFiles
     * @throws \Exception
     */
    public function goToInboundFiles(
        Main $main,
        Auth $auth

    ):void
    {
        $auth -> login();
        $main -> goToDso();
        $main -> switchToInboundSalesFiles();
    }
}