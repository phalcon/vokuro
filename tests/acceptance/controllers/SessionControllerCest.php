<?php
declare(strict_types=1);

class SessionControllerCest
{
    public function testLogin(\AcceptanceTester $I): void
    {
        $I->amOnPage('/session/login');
        $I->see('Log In');
    }
}
