<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Providers;

use Codeception\Test\Unit;
use Phalcon\Di\ServiceProviderInterface;
use Vokuro\Providers\ViewProvider;

final class ViewProviderTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(ViewProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }
}
