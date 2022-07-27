<?php

namespace Page;

use AcceptanceTester;

class Base
{
    protected AcceptanceTester $tester;

    public function __construct(AcceptanceTester $I)
    {
        $this->tester = $I;
    }

}