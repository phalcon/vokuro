<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Providers;

use Codeception\Test\Unit;
use Phalcon\Assets\Manager as AssetsManager;
use Vokuro\Providers\AssetsProvider;

final class AssetsProviderTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(AssetsProvider::class);

        $this->assertInstanceOf(AssetsManager::class, $class);
    }
}
