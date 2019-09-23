<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Plugins;

use Codeception\Test\Unit;
use Phalcon\Di\Injectable;
use Vokuro\Plugins\Auth\Auth;

final class AuthTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(Auth::class);

        $this->assertInstanceOf(Injectable::class, $class);
    }
}
