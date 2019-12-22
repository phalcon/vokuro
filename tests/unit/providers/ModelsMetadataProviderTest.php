<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Providers;

use Codeception\Test\Unit;
use Phalcon\Di\ServiceProviderInterface;
use Vokuro\Providers\ModelsMetadataProvider;

final class ModelsMetadataProviderTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(ModelsMetadataProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }
}
