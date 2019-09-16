<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit;

use Codeception\Test\Unit;
use Vokuro\Application;

final class ApplicationTest extends Unit
{
    public function testConstructAndGetRootPath(): void
    {
        $rootPath = 'test/path';
        $class = $this->constructEmptyExcept(Application::class, 'getRootPath', ['rootPath' => $rootPath]);

        $this->assertEquals($rootPath, $class->getRootPath());
    }
}
