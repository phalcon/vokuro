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
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Providers\LoggerProvider;

final class LoggerProviderTest extends AbstractUnitTestCase
{
    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(LoggerProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }

    public function testRegistersLoggerService(): void
    {
        $di = new FactoryDefault();
        $di->setShared('config', new Config([
            'logger' => [
                'filename' => 'test.log',
                'path'     => dirname(__DIR__, 2) . '/_output',
                'format'   => '%message%',
                'date'     => 'Y-m-d',
            ],
        ]));

        (new LoggerProvider())->register($di);

        $this->assertInstanceOf(Stream::class, $di->get('logger'));
    }
}
