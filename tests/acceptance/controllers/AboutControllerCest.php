<?php
declare(strict_types=1);

final class AboutControllerCest
{
    public function testIndex(\AcceptanceTester $I): void
    {
        $I->amOnPage('/about');
        $I->see('About this Demo');
    }
}
