<?php
declare(strict_types=1);

namespace Vokuro\Tests\Acceptance\Controllers;

use AcceptanceTester;

final class TermsControllerCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function testIndex(AcceptanceTester $I): void
    {
        $I->amOnPage('/terms');
        $I->see('Terms');
    }
}
