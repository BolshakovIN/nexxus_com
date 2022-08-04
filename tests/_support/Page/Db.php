<?php

namespace Page;

use AcceptanceTester;
use Exception;
use Page\Base;

class Db extends Base
{
    /**
     * Подключение к базе nexxus-qa
     */
    public function connectDbWtis(): void
    {
        $I = $this->tester;
        $I->amConnectedToDatabase('default');
    }

    /** Первый пробный тест */
    public function connectDb(): void
    {
        $I = $this->tester;
        $I->seeInDatabase('[nexxus-qa].core.Client', ['VendorId' => '9826']);
    }
}
