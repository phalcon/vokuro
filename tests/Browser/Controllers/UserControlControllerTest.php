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

final class UserControlControllerTest extends AbstractBrowserTestCase
{
    public function testConfirmEmailActivatesUser(): void
    {
        // Signing up creates an inactive user plus a pending email confirmation.
        $this->visitPage('/session/signup');
        $this->fillField('name', 'Peter Silberman');
        $this->fillField('email', 'peter.silberman@pescadero.dev');
        $this->fillField('password', 'password1');
        $this->fillField('confirmPassword', 'password1');
        $this->fillField('terms', 'yes');
        $this->pressButton('Sign Up');

        $code = $this->latestCode('email_confirmations');

        $this->visitPage('/confirm/' . $code . '/peter.silberman@pescadero.dev');
        $this->assertPageContainsText('The email was successfully confirmed');
    }

    public function testConfirmEmailAlreadyConfirmed(): void
    {
        $this->pdo()->exec(
            "INSERT INTO email_confirmations (usersId, code, createdAt, confirmed)"
            . " VALUES (1, 'alreadyconfirmedcode', UNIX_TIMESTAMP(), 'Y')"
        );

        $this->visitPage('/confirm/alreadyconfirmedcode/sarah.connor@skynet.dev');
        $this->assertPageContainsText('Log In');
    }

    public function testConfirmEmailRequiringPasswordChange(): void
    {
        // A user created by an admin gets a generated password and so must change
        // it on first login.
        $this->loginAsAdmin();
        $this->visitPage('/users/create');
        $this->fillField('name', 'Douglas');
        $this->fillField('email', 'douglas@pescadero.dev');
        $this->selectOption('profilesId', '1');
        $this->pressButton('Save');

        $code = $this->latestCode('email_confirmations');

        $this->visitPage('/confirm/' . $code . '/douglas@pescadero.dev');
        $this->assertPageContainsText('Change Password');
    }

    public function testConfirmEmailWithUnknownCode(): void
    {
        $this->visitPage('/confirm/nosuchcode/nobody@skynet.dev');
        $this->assertPageContainsText('Welcome!');
    }

    public function testResetPasswordAllowsChange(): void
    {
        // Requesting a reset creates a reset-password record for the account.
        $this->visitPage('/session/forgotPassword');
        $this->fillField('email', 'sarah.connor@skynet.dev');
        $this->pressButton('Send');

        $code = $this->latestCode('reset_passwords');

        $this->visitPage('/reset-password/' . $code . '/sarah.connor@skynet.dev');
        $this->assertPageContainsText('Change Password');
    }

    public function testResetPasswordAlreadyReset(): void
    {
        $this->pdo()->exec(
            "INSERT INTO reset_passwords (usersId, code, createdAt, modifiedAt, reset)"
            . " VALUES (1, 999111, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), 'Y')"
        );

        $this->visitPage('/reset-password/999111/sarah.connor@skynet.dev');
        $this->assertPageContainsText('Log In');
    }

    public function testResetPasswordWithUnknownCode(): void
    {
        $this->visitPage('/reset-password/888222/nobody@skynet.dev');
        $this->assertPageContainsText('Welcome!');
    }

    private function latestCode(string $table): string
    {
        return (string) $this->pdo()
            ->query('SELECT code FROM ' . $table . ' ORDER BY id DESC LIMIT 1')
            ->fetchColumn();
    }
}
