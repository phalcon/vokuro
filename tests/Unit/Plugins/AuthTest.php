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

namespace Vokuro\Tests\Unit\Plugins;

use Phalcon\Di\Di;
use Phalcon\Di\Injectable;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Application;
use Vokuro\Plugins\Auth\Auth;
use Vokuro\Plugins\Auth\Exception;
use Vokuro\Tests\Support\DatabaseSeedTrait;

use function hash;

final class AuthTest extends AbstractUnitTestCase
{
    use DatabaseSeedTrait;

    protected function tearDown(): void
    {
        // Don't leak remember-me cookies or session identity into later tests.
        unset($_COOKIE['RMU'], $_COOKIE['RMT']);
        $_SESSION = [];

        parent::tearDown();
    }

    public function testAuthUserByIdThrowsWhenUserDoesNotExist(): void
    {
        $this->reseedDatabase();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The user does not exist');

        $this->bootAuth()->authUserById(999);
    }

    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(Auth::class);

        $this->assertInstanceOf(Injectable::class, $class);
    }

    public function testGetUserThrowsWhenSessionIsBroken(): void
    {
        $auth = $this->bootAuth();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Session was broken');

        $auth->getUser();
    }

    public function testGetUserThrowsWhenUserDoesNotExist(): void
    {
        $this->reseedDatabase();

        $auth = $this->bootAuth();
        Di::getDefault()->getShared('session')->set('auth-identity', [
            'id'      => 999,
            'name'    => 'Ghost',
            'profile' => 'Administrators',
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The user does not exist');

        $auth->getUser();
    }

    public function testRemoveRevokesTheStoredToken(): void
    {
        $this->reseedDatabase();

        // The token is stored hashed; the RMT cookie carries the raw value.
        $this->pdo()
            ->prepare('INSERT INTO remember_tokens (usersId, token, userAgent, createdAt) VALUES (1, ?, ?, ?)')
            ->execute([hash('sha256', 'pescadero'), 'phpunit', time()]);

        $_COOKIE['RMU'] = '1';
        $_COOKIE['RMT'] = 'pescadero';

        $this->bootAuth()->remove();

        $count = (int) $this->pdo()->query('SELECT COUNT(*) FROM remember_tokens')->fetchColumn();

        $this->assertSame(0, $count);
    }

    private function bootAuth(): Auth
    {
        $_SESSION = [];

        new Application(dirname(__DIR__, 3));
        $container = Di::getDefault();

        // The harness carries raw cookie values, so read them unencrypted.
        $container->getShared('cookies')->useEncryption(false);

        return $container->getShared('auth');
    }
}
