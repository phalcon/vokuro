<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Providers;

use Codeception\Test\Unit;
use Phalcon\Di\ServiceProviderInterface;
use Vokuro\Providers\FlashProvider;

final class FlashProviderTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(FlashProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }
}
