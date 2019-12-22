<?php
declare(strict_types=1);

namespace Vokuro\Tests\Acceptance\Controllers;

use AcceptanceTester;

final class PermissionsControllerCest
{
    /**
     * @var string|null
     */
    private $cookie = null;

    /**
     * @param AcceptanceTester $I
     */
    public function login(AcceptanceTester $I): void
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
     * @param AcceptanceTester $I
     */
    public function testIndex(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/permissions');
        $I->see('Manage Permissions');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function testIndexAsGuest(AcceptanceTester $I): void
    {
        $I->amOnPage('/permissions');
        $I->see('You don\'t have access to this module: private');
    }
}
