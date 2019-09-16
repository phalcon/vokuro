<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Models;

use Codeception\Test\Unit;
use Phalcon\Mvc\Model;
use Vokuro\Models\FailedLogins;

final class FailedLoginsTest extends Unit
{
    public function testModelInstanceOf(): void
    {
        $class = $this->make(FailedLogins::class);

        $this->assertInstanceOf(Model::class, $class);
    }
}
