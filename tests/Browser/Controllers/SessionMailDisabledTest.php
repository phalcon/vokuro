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
 * Exercises the "emails disabled" config branch: forgot-password warns instead
 * of sending, and signup activates the account immediately.
 */
final class SessionMailDisabledTest extends AbstractBrowserTestCase
{
    public function testForgotPasswordWarnsWhenMailIsDisabled(): void
    {
        $this->visitPage('/session/forgotPassword');
        $this->fillField('email', 'sarah.connor@skynet.dev');
        $this->pressButton('Send');

        $this->assertPageContainsText('Emails are currently disabled');
    }

    public function testSignupActivatesTheAccountWhenMailIsDisabled(): void
    {
        $this->visitPage('/session/signup');
        $this->fillField('name', 'Janelle Voight');
        $this->fillField('email', 'janelle.voight@resistance.dev');
        $this->fillField('password', 'password1');
        $this->fillField('confirmPassword', 'password1');
        $this->fillField('terms', 'yes');
        $this->pressButton('Sign Up');

        $this->assertPageContainsText('Welcome!');

        $active = $this->pdo()
            ->query("SELECT active FROM users WHERE email = 'janelle.voight@resistance.dev'")
            ->fetchColumn();
        $this->assertSame('Y', $active);
    }

    protected function appFactory(): callable
    {
        $factory = parent::appFactory();

        return function () use ($factory) {
            $app = $factory();
            $app->getDI()->getShared('config')->offsetSet('useMail', false);

            return $app;
        };
    }
}
