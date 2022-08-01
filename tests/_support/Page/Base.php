<?php

namespace Page;

use AcceptanceTester;


class Base
{
    /**
     * @param AcceptanceTester $tester
     */
    public function __construct(protected AcceptanceTester $tester)
    {

    }

}