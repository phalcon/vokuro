<?php
declare(strict_types=1);

class UsersControllerCest
{
    public function testIndexAsGuest(\AcceptanceTester $I): void
    {
        $I->amOnPage('/users');
        $I->see('You don\'t have access to this module: private');
    }
}
