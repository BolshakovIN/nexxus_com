<?php

namespace Page;

use AcceptanceTester;
use Exception;
use Page\Credentials;

class Auth
{
    /** url*/
    private const URL = '/';
    /** Поле ввода пароля */
    private const BUTTON = '#idSIButton9';
    /** Поле ввода email при авторизации*/
    private const EMAIL_FIELD = '#i0116';
    /** Поле ввода пароля при авторизации*/
    private const PASSWORD_FIELD = '#i0118';
    /** Линк разлогина */
    private const LOGOUT_LINK = 'Logout';
    /** pass and login*/
    //private const USER_CREDENTIALS = ['ivan.bolshakov@epicsoftwaredev.com', 'volvoman101'];

    private AcceptanceTester $tester;
    private Credentials $credentials;

    public function __construct(AcceptanceTester $tester, Credentials $credentials)
    {
        $this->tester = $tester;
        $this->credentials = $credentials;
    }

    /**
     * Залогиниться в приложении
     *
     * @throws Exception
     */
    public function login():void
    {
        $I = $this->tester;
        $credentials = $this->credentials;
        [$username, $password] = $credentials -> getCredentials();
        $I->amOnPage(self::URL);
        $I->wait('2');
        $I->seeElementInDOM(self::EMAIL_FIELD);
        $I->fillField(self::EMAIL_FIELD, $username);
        $I->clickWithLeftButton(self::BUTTON);
        $I->waitForElementClickable(self::PASSWORD_FIELD);
        $I->clickWithLeftButton(self::PASSWORD_FIELD);
        $I->fillField(self::PASSWORD_FIELD, $password);
        $I->waitForElementClickable(self::BUTTON);
        $I->seeElement(self::BUTTON);
        $I->clickWithLeftButton(self::BUTTON);
        $I->waitForElementClickable(self::BUTTON);
        $I->clickWithLeftButton(self::BUTTON);
        $I->waitForText('Relationships',30);
        $I->see('Relationships');
    }

    /** Разлогиниться в приложении */
    public function logout():void
    {
        $I = $this->tester;
        $I -> clickWithLeftButton('body > section > header > div:nth-child(3) > div.el-dropdown.actions-wrapper__popover > div > span');
        $I -> wait(3);
        $I -> click(self::LOGOUT_LINK);
        $I -> waitForText('Выберите учетную запись',20);
        $I -> see('Выберите учетную запись');
        $I -> see('Используйте другую учетную запись');
    }
}

