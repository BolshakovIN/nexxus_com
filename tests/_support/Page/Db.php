<?php

namespace Page;
use AcceptanceTester;
use Exception;

class Db
{
    private $tester;

    public function __construct($tester)
    {
        $this -> tester = $tester;
    }
    /**
     * Подключение к базе
     */
    public function connectDb(): void
    {
        $I = $this->tester;
        $I->amConnectedToDatabase('default');
    }
}