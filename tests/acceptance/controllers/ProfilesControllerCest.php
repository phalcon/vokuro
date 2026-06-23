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
        $I->fillField('email', 'sarah.connor@skynet.dev');
        $I->fillField('password', 'password1');
        $I->click('//form/*[@type="submit"]');
        $I->see('Search users');

        $this->cookie = $I->grabCookie('PHPSESSID');
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
    public function testDelete(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        // Provision a throwaway profile so the test is self-contained and
        // repeatable: it creates and removes its own record instead of
        // consuming seeded data (profiles with users cannot be deleted anyway).
        $I->amOnPage('/profiles/create');
        $I->fillField('name', 'Delete Me');
        $I->selectOption('active', 'Yes');
        $I->click('Save');
        $I->see('Profile was created successfully');

        // It has no users assigned, so it can be deleted.
        $I->amOnPage('/profiles');
        $I->see('Delete Me');
        $I->click('Delete', '//tr[td[contains(., "Delete Me")]]');

        // The record is gone and the seeded profiles are untouched.
        $I->amOnPage('/profiles');
        $I->cantSee('Delete Me');
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
    public function testIndex(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/profiles');
        $I->see('Search profiles');
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
    public function testSearch(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/profiles');
        $I->click('Search');
        $I->see('Found profiles');
    }
}
