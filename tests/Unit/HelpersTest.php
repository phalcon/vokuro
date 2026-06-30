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

namespace Vokuro\Tests\Unit;

use Phalcon\Di\FactoryDefault;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;

use function Vokuro\container;
use function Vokuro\env;

final class HelpersTest extends AbstractUnitTestCase
{
    public function testContainerWithoutArgumentsReturnsTheDefaultContainer(): void
    {
        $di = new FactoryDefault();

        $this->assertSame($di, container());
    }

    public function testEnvFallsBackToTheEnvSuperglobalThenTheDefault(): void
    {
        $_ENV['VOKURO_HELPER_PROBE'] = 'from-env';

        $this->assertSame('from-env', env('VOKURO_HELPER_PROBE'));
        $this->assertSame('fallback', env('VOKURO_HELPER_MISSING', 'fallback'));

        unset($_ENV['VOKURO_HELPER_PROBE']);
    }
}
