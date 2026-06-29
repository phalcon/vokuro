<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vokuro\Tests\Browser\Controllers;

use Vokuro\Tests\Browser\AbstractBrowserTestCase;

final class AuthRememberMeTest extends AbstractBrowserTestCase
{
    public function testRememberMeStoresToken(): void
    {
        // Logging in with the box ticked persists a hashed remember-me token.
        $this->visitPage('/session/login');
        $this->fillField('email', 'sarah.connor@skynet.dev');
        $this->fillField('password', 'password1');
        $this->fillField('remember', 'yes');
        $this->pressButton('//form/*[@type="submit"]');
        $this->assertPageContainsText('Search users');

        $count = (int) $this->pdo()->query('SELECT COUNT(*) FROM remember_tokens')->fetchColumn();

        $this->assertSame(1, $count);
    }
}
