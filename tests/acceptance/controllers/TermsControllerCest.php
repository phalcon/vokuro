<?php
declare(strict_types=1);

final class TermsControllerCest
{
    public function testIndex(\AcceptanceTester $I): void
    {
        $I->amOnPage('/terms');
        $I->see('Terms');
    }
}
