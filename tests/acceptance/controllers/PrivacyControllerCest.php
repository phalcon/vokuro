<?php
declare(strict_types=1);

namespace Vokuro\Tests\Acceptance\Controllers;

use AcceptanceTester;

final class PrivacyControllerCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function testIndex(AcceptanceTester $I): void
    {
        $I->amOnPage('/privacy');
        $I->see('Privacy');
    }
}
