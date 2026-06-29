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

namespace Vokuro\Tests\Unit\Providers;

use Phalcon\Config\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Application;
use Vokuro\Exception;
use Vokuro\Providers\DbProvider;

final class DbProviderTest extends AbstractUnitTestCase
{
    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(DbProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }

    public function testRegistersPostgresAdapter(): void
    {
        $di = $this->containerWithAdapter('pgsql');

        (new DbProvider())->register($di);

        $this->assertTrue($di->has('db'));
    }

    public function testRegistersSqliteAdapter(): void
    {
        $di = $this->containerWithAdapter('sqlite');

        (new DbProvider())->register($di);

        $this->assertTrue($di->has('db'));
    }

    public function testThrowsForUnknownAdapter(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Adapter "unknown" has not been registered');

        (new DbProvider())->register($this->containerWithAdapter('unknown'));
    }

    private function containerWithAdapter(string $adapter): FactoryDefault
    {
        $di = new FactoryDefault();
        $di->setShared(Application::APPLICATION_PROVIDER, $this->mockWithoutConstructor(Application::class, [
            'rootPath' => dirname(__DIR__, 3),
        ]));
        $di->setShared('config', new Config([
            'database' => [
                'adapter'  => $adapter,
                'host'     => 'localhost',
                'port'     => '3306',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'vokuro',
                'charset'  => 'utf8',
            ],
        ]));

        return $di;
    }
}
