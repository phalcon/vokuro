<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Models;

use Codeception\Test\Unit;
use Phalcon\Mvc\Model;
use Vokuro\Models\ResetPasswords;

final class ResetPasswordsTest extends Unit
{
    public function testModelInstanceOf(): void
    {
        $class = $this->make(ResetPasswords::class);

        $this->assertInstanceOf(Model::class, $class);
    }
}
