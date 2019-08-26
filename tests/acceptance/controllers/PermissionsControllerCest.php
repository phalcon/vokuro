<?php
declare(strict_types=1);

final class PermissionsControllerCest
{
    private $cookie = null;

    public function login(\AcceptanceTester $I): void
    {
        $I->amOnPage('/session/login');
        $I->see('Log In');
        $I->fillField('email', 'bob@phalcon.io');
        $I->fillField('password', 'password1');
        $I->click('//form/*[@type="submit"]');
        $I->see('Search users');

        $this->cookie = $I->grabCookie('PHPSESSID');
    }

    /**
     * @depends login
     */
    public function testIndex(\AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/permissions');
        $I->see('Manage Permissions');
    }

    public function testIndexAsGuest(\AcceptanceTester $I): void
    {
        $I->amOnPage('/permissions');
        $I->see('You don\'t have access to this module: private');
    }
}
