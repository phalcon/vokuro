<?php
declare(strict_types=1);

final class IndexControllerCest
{
    public function testIndex(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->see('Welcome!');
    }
}
