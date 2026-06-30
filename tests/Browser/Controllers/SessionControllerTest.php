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

final class SessionControllerTest extends AbstractBrowserTestCase
{
    public function testForgotPasswordWithInvalidEmail(): void
    {
        $this->visitPage('/session/forgotPassword');
        $this->fillField('email', 'not-an-email');
        $this->pressButton('Send');

        $this->assertPageContainsText('The e-mail is not valid');
    }

    public function testForgotPasswordWithKnownEmail(): void
    {
        $this->visitPage('/session/forgotPassword');
        $this->fillField('email', 'sarah.connor@skynet.dev');
        $this->pressButton('Send');

        $this->assertPageContainsText('Success! Please check your messages for an email reset password');
    }

    public function testForgotPasswordWithUnknownEmail(): void
    {
        $this->visitPage('/session/forgotPassword');
        $this->fillField('email', 't-1000@skynet.dev');
        $this->pressButton('Send');

        $this->assertPageContainsText('There is no account associated to this email');
    }

    public function testIndexRedirectsToLogin(): void
    {
        $this->visitPage('/session');

        $this->assertPageContainsText('Log In');
    }

    public function testLoginShowsValidationErrors(): void
    {
        $this->visitPage('/session/login');
        $this->pressButton('//form/*[@type="submit"]');

        $this->assertPageContainsText('The e-mail is required');
    }

    public function testLoginThenLogout(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/session/logout');
        $this->assertPageContainsText('Welcome!');
    }

    public function testLoginWithBannedUser(): void
    {
        $this->pdo()->exec("UPDATE users SET banned = 'Y' WHERE id = 1");

        $this->visitPage('/session/login');
        $this->fillField('email', 'sarah.connor@skynet.dev');
        $this->fillField('password', 'password1');
        $this->pressButton('//form/*[@type="submit"]');

        $this->assertPageContainsText('The user is banned');
    }

    public function testLoginWithInactiveUser(): void
    {
        $this->pdo()->exec("UPDATE users SET active = 'N' WHERE id = 1");

        $this->visitPage('/session/login');
        $this->fillField('email', 'sarah.connor@skynet.dev');
        $this->fillField('password', 'password1');
        $this->pressButton('//form/*[@type="submit"]');

        $this->assertPageContainsText('The user is inactive');
    }

    public function testLoginWithSuspendedUser(): void
    {
        $this->pdo()->exec("UPDATE users SET suspended = 'Y' WHERE id = 1");

        $this->visitPage('/session/login');
        $this->fillField('email', 'sarah.connor@skynet.dev');
        $this->fillField('password', 'password1');
        $this->pressButton('//form/*[@type="submit"]');

        $this->assertPageContainsText('The user is suspended');
    }

    public function testLoginWithWrongEmail(): void
    {
        $this->visitPage('/session/login');
        $this->fillField('email', 't-1000@skynet.dev');
        $this->fillField('password', 'wrong-password');
        $this->pressButton('//form/*[@type="submit"]');

        $this->assertPageContainsText('Wrong email/password combination');
    }

    public function testLoginWithWrongPassword(): void
    {
        $this->visitPage('/session/login');
        $this->fillField('email', 'sarah.connor@skynet.dev');
        $this->fillField('password', 'wrong-password');
        $this->pressButton('//form/*[@type="submit"]');

        $this->assertPageContainsText('Wrong email/password combination');
    }

    public function testLogoutAsGuest(): void
    {
        $this->visitPage('/session/logout');

        $this->assertPageContainsText('Welcome!');
    }

    public function testRepeatedFailedLoginsAreThrottled(): void
    {
        // Five wrong-password attempts walk the throttling escalation
        // (no delay -> 2s -> 4s); sleep() is shadowed in tests so it stays fast.
        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this->visitPage('/session/login');
            $this->fillField('email', 'sarah.connor@skynet.dev');
            $this->fillField('password', 'wrong-password');
            $this->pressButton('//form/*[@type="submit"]');
            $this->assertPageContainsText('Wrong email/password combination');
        }

        $count = (int) $this->pdo()->query('SELECT COUNT(*) FROM failed_logins')->fetchColumn();

        $this->assertSame(5, $count);
    }

    public function testSignupCreatesAccount(): void
    {
        $this->visitPage('/session/signup');
        $this->fillField('name', 'Enrique Salceda');
        $this->fillField('email', 'enrique.salceda@resistance.dev');
        $this->fillField('password', 'password1');
        $this->fillField('confirmPassword', 'password1');
        $this->fillField('terms', 'yes');
        $this->pressButton('Sign Up');

        $this->assertPageContainsText('Welcome!');
    }

    public function testSignupShowsValidationErrors(): void
    {
        $this->visitPage('/session/signup');
        $this->pressButton('Sign Up');

        $this->assertPageContainsText('The name is required');
    }

    public function testSignupWithExistingEmailIsRejected(): void
    {
        $this->visitPage('/session/signup');
        $this->fillField('name', 'Sarah Clone');
        $this->fillField('email', 'sarah.connor@skynet.dev');
        $this->fillField('password', 'password1');
        $this->fillField('confirmPassword', 'password1');
        $this->fillField('terms', 'yes');
        $this->pressButton('Sign Up');

        $this->assertPageContainsText('The email is already registered');
    }
}
