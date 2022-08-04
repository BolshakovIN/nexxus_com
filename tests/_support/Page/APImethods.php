<?php

namespace Page;

use AcceptanceTester;
use Codeception\Util\HttpCode;

class APImethods extends Base

{
    public function getUser($clientId)
    {
        $I = $this->tester;
        $I ->sendGet('/api/client/', ['clientId'=>$clientId]);
        $I -> seeResponseCodeIs(HttpCode::OK);
    }
}