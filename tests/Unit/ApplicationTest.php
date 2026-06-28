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

use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Application;

final class ApplicationTest extends AbstractUnitTestCase
{
    public function testConstructAndGetRootPath(): void
    {
        $rootPath = 'test/path';
        $class = $this->mockWithConstructor(
            Application::class,
            [$rootPath],
            [
                'createApplication' => null,
                'initializeProviders' => null,
            ]
        );

        $this->assertEquals($rootPath, $class->getRootPath());
    }
}
