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

namespace Vokuro\Tests\Browser;

use Phalcon\Di\Di;
use Phalcon\Talon\PHPUnit\AbstractBrowserTestCase as TalonBrowserTestCase;
use Vokuro\Application;
use Vokuro\Tests\Support\DatabaseSeedTrait;

abstract class AbstractBrowserTestCase extends TalonBrowserTestCase
{
    use DatabaseSeedTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->reseedDatabase();
    }

    /**
     * Build a fresh app per request. Phalcon models resolve services through the
     * default DI, so each request resets it and lets the new app become default;
     * session/cookie continuity is carried by $_SESSION and the browser jar.
     */
    protected function appFactory(): callable
    {
        return function () {
            Di::reset();
            $bootstrap = new Application(dirname(__DIR__, 2));
            $app       = $this->getProtectedProperty($bootstrap, 'app');

            // The in-process browser carries raw cookie values in its jar, so the
            // app must not encrypt/decrypt them. Production keeps encryption on.
            $app->getDI()->getShared('cookies')->useEncryption(false);

            return $app;
        };
    }

    protected function loginAs(string $email, string $password): void
    {
        $this->visitPage('/session/login');
        $this->fillField('email', $email);
        $this->fillField('password', $password);
        $this->pressButton('//form/*[@type="submit"]');
        $this->assertPageContainsText('Search users');
    }

    protected function loginAsAdmin(): void
    {
        $this->loginAs('sarah.connor@skynet.dev', 'password1');
    }
}
