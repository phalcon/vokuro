<?php
declare(strict_types=1);

final class PrivacyControllerCest
{
    public function testIndex(\AcceptanceTester $I): void
    {
        $I->amOnPage('/privacy');
        $I->see('Privacy');
    }
}
