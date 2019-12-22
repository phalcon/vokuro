<?php
declare(strict_types=1);

namespace Vokuro\Tests\Acceptance\Controllers;

use AcceptanceTester;

final class AboutControllerCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function testIndex(AcceptanceTester $I): void
    {
        $I->amOnPage('/about');
        $I->see('About this Demo');
    }
}
