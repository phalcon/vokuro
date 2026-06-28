<?php

declare(strict_types=1);

namespace Vokuro\Tests\Acceptance\Controllers;

use AcceptanceTester;

class SessionControllerCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function testLogoutAsGuest(AcceptanceTester $I): void
    {
        $I->amOnPage('/session/logout');
        $I->see('Welcome!');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function testLogoutAsUser(AcceptanceTester $I): void
    {
        $I->amOnPage('/session/login');
        $I->see('Log In');
        $I->fillField('email', 'sarah.connor@skynet.dev');
        $I->fillField('password', 'password1');
        $I->click('//form/*[@type="submit"]');
        $I->see('Search users');
        $I->amOnPage('/session/logout');
        $I->see('Welcome!');
    }
}
