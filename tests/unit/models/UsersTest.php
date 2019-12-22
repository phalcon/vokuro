<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Models;

use Codeception\Test\Unit;
use Phalcon\Mvc\Model;
use Vokuro\Models\Users;

final class UsersTest extends Unit
{
    public function testModelInstanceOf(): void
    {
        $class = $this->make(Users::class);

        $this->assertInstanceOf(Model::class, $class);
    }
}
