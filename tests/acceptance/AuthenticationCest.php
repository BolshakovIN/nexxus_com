<?php

use Page\Auth;

class AuthenticationCest
{
    /**
     *Тест на проверку входа со случайными кредами
     *
     * @throws \Exception
     */
    public function login (
        Auth $auth
    ):void
    {
        $auth -> login();
    }

    /**
     *Тест на проверку входа и выходы со случайными кредами
     *
     * @throws \Exception
     */
    public function logout
    (
        Auth $auth
    ):void
    {
        $auth -> login();
        $auth -> logout();
    }
}
