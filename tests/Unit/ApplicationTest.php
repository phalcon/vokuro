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
use Vokuro\Exception;

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

    public function testRunReturnsRenderedContent(): void
    {
        $_SERVER['REQUEST_URI'] = '/';

        $application = new Application(dirname(__DIR__, 2));

        $this->assertStringContainsString('Welcome!', $application->run());
    }

    public function testThrowsWhenProvidersFileMissing(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('providers.php does not exist');

        new Application('/nonexistent-vokuro-root');
    }
}
