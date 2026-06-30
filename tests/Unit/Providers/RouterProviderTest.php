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

use Phalcon\Di\FactoryDefault;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Application;
use Vokuro\Exception;
use Vokuro\Providers\RouterProvider;

final class RouterProviderTest extends AbstractUnitTestCase
{
    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(RouterProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }

    public function testThrowsWhenRoutesFileMissing(): void
    {
        $bootstrap = $this->mockWithoutConstructor(Application::class, [
            'rootPath' => '/nonexistent-vokuro-root',
        ]);

        $di = new FactoryDefault();
        $di->setShared(Application::APPLICATION_PROVIDER, $bootstrap);

        (new RouterProvider())->register($di);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('routes.php file does not exist or is not readable.');

        $di->get('router');
    }
}
