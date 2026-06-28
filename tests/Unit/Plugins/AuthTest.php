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

use Phalcon\Di\Injectable;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Plugins\Auth\Auth;

final class AuthTest extends AbstractUnitTestCase
{
    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(Auth::class);

        $this->assertInstanceOf(Injectable::class, $class);
    }
}
