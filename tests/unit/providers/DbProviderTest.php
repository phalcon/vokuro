<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Providers;

use Codeception\Test\Unit;
use Phalcon\Di\ServiceProviderInterface;
use Vokuro\Providers\DbProvider;

final class DbProviderTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(DbProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }
}
