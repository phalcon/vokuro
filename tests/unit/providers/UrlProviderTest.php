<?php

declare(strict_types=1);

namespace Vokuro\Tests\Unit\Providers;

use Codeception\Test\Unit;
use Phalcon\Di\ServiceProviderInterface;
use Vokuro\Providers\UrlProvider;

final class UrlProviderTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(UrlProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }
}
