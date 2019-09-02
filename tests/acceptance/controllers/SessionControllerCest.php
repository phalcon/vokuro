<?php
declare(strict_types=1);

class SessionControllerCest
{
    public function testLogin(\AcceptanceTester $I): void
    {
        $I->amOnPage('/session/login');
        $I->see('Log In');
    }

    public function testSignup(\AcceptanceTester $I): void
    {
        $I->amOnPage('/session/signup');
        $I->see('Sign up');
    }

    public function testForgotPassword(\AcceptanceTester $I): void
    {
        $I->amOnPage('/session/forgotPassword');
        $I->see('Forgot Password?');
    }

    public function testLogoutAsGuest(\AcceptanceTester $I): void
    {
        $I->amOnPage('/session/logout');
        $I->see('Welcome!');
    }

    public function testLogoutAsUser(\AcceptanceTester $I): void
    {
        $I->amOnPage('/session/login');
        $I->see('Log In');
        $I->fillField('email', 'bob@phalcon.io');
        $I->fillField('password', 'password1');
        $I->click('//form/*[@type="submit"]');
        $I->see('Search users');
        $I->amOnPage('/session/logout');
        $I->see('Welcome!');
    }
}
