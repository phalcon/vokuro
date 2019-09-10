<?php
declare(strict_types=1);

namespace Vokuro\Tests\Acceptance\Controllers;

use AcceptanceTester;

final class ProfilesControllerCest
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
     * @param AcceptanceTester $I
     */
    public function testIndexAsGuest(AcceptanceTester $I): void
    {
        $I->amOnPage('/profiles');
        $I->see('You don\'t have access to this module: private');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testIndex(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/profiles');
        $I->see('Search profiles');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testSearch(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/profiles');
        $I->click('Search');
        $I->see('Found profiles');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testCreate(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/profiles/create');
        $I->see('Create a Profile');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testEdit(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/profiles/edit/1');
        $I->see('Edit profile');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testDelete(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/profiles');
        $I->click('Search');
        $I->see('Found profiles');
        $I->see('Administrators');

        $I->click('//a[@href="/profiles/delete/1"]');

        $I->amOnPage('/profiles');
        $I->see('Search');
        $I->cantSee('Administrators');
    }
}
