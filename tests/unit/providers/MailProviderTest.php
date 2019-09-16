<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Providers;

use Codeception\Test\Unit;
use Phalcon\Di\ServiceProviderInterface;
use Vokuro\Providers\MailProvider;

final class MailProviderTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(MailProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }
}
