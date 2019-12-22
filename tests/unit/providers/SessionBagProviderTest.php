<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Providers;

use Codeception\Test\Unit;
use Phalcon\Di\ServiceProviderInterface;
use Vokuro\Providers\SessionBagProvider;

final class SessionBagProviderTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(SessionBagProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }
}
