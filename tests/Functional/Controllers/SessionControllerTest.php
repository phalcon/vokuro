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

namespace Vokuro\Tests\Functional\Controllers;

use Vokuro\Tests\Functional\AbstractFunctionalTestCase;

final class SessionControllerTest extends AbstractFunctionalTestCase
{
    public function testForgotPassword(): void
    {
        $this->dispatch('/session/forgotPassword');

        $this->assertResponseContentContains('Forgot Password?');
    }

    public function testLogin(): void
    {
        $this->dispatch('/session/login');

        $this->assertResponseContentContains('Log In');
    }

    public function testSignup(): void
    {
        $this->dispatch('/session/signup');

        $this->assertResponseContentContains('Sign Up');
    }
}
