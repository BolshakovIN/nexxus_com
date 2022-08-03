<?php

namespace Page;

use AcceptanceTester;
use Codeception\Util\HttpCode;

class APImethods extends Base

{
    public function get()
    {
        $I = $this->tester;
        $I ->sendGet('/api/client/', ['clientId'=>'9826']);
    }
}