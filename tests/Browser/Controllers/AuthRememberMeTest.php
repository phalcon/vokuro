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

/**
 * Exercises the "remember me" cookie flow end to end: a login with the box
 * ticked stores a hashed token and sets the RMU/RMT cookies, a later visit to
 * the login page authenticates straight from them, an unmatched cookie falls
 * back to the login form, and logout clears the token.
 */
final class AuthRememberMeTest extends AbstractBrowserTestCase
{
    public function testLogoutClearsRememberToken(): void
    {
        $this->loginRemembering();
        $this->assertSame(1, $this->rememberTokenCount());

        $this->visitPage('/session/logout');
        $this->assertPageContainsText('Welcome!');
        $this->assertSame(0, $this->rememberTokenCount());
    }

    public function testRememberMeLogsInOnReturn(): void
    {
        $this->loginRemembering();

        $this->visitPage('/session/login');
        $this->assertPageContainsText('Search users');
    }

    public function testRememberMeStoresToken(): void
    {
        $this->loginRemembering();

        $this->assertSame(1, $this->rememberTokenCount());
    }

    public function testRememberMeWithInvalidCookieRendersLogin(): void
    {
        $this->setCookie('RMU', '1');
        $this->setCookie('RMT', 'bogus-token');

        $this->visitPage('/session/login');
        $this->assertPageContainsText('Log In');
    }

    private function loginRemembering(): void
    {
        $this->visitPage('/session/login');
        $this->fillField('email', 'sarah.connor@skynet.dev');
        $this->fillField('password', 'password1');
        $this->fillField('remember', 'yes');
        $this->pressButton('//form/*[@type="submit"]');
        $this->assertPageContainsText('Search users');
    }

    private function rememberTokenCount(): int
    {
        return (int) $this->pdo()->query('SELECT COUNT(*) FROM remember_tokens')->fetchColumn();
    }
}
