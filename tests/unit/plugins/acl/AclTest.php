<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Plugins;

use Codeception\Test\Unit;
use Phalcon\Di\Injectable;
use Vokuro\Plugins\Acl\Acl;

final class AclTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(Acl::class);

        $this->assertInstanceOf(Injectable::class, $class);
    }
}
