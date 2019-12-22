<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Providers;

use Codeception\Test\Unit;
use Phalcon\Di\ServiceProviderInterface;
use Vokuro\Providers\ConfigProvider;

final class ConfigProviderTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(ConfigProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }
}
