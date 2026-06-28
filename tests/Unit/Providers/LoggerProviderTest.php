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

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Providers\LoggerProvider;

final class LoggerProviderTest extends AbstractUnitTestCase
{
    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(LoggerProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }
}
