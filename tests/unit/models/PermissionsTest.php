<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Models;

use Codeception\Test\Unit;
use Phalcon\Mvc\Model;
use Vokuro\Models\Permissions;

final class PermissionsTest extends Unit
{
    public function testModelInstanceOf(): void
    {
        $class = $this->make(Permissions::class);

        $this->assertInstanceOf(Model::class, $class);
    }
}
