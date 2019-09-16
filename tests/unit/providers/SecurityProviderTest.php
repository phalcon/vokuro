<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Providers;

use Codeception\Test\Unit;
use Phalcon\Di\ServiceProviderInterface;
use Vokuro\Providers\SecurityProvider;

final class SecurityProviderTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(SecurityProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }
}
