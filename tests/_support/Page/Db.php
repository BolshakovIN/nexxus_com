<?php

namespace Page;
use AcceptanceTester;
use Exception;
use Page\Base;

class Db extends Base
{

    /**
     * Подключение к базе
     */
    public function connectDb(): void
    {
        $I = $this->tester;
        $I->amConnectedToDatabase();
    }
}