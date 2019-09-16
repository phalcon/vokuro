<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Models;

use Codeception\Test\Unit;
use Phalcon\Mvc\Model;
use Vokuro\Models\PasswordChanges;

final class PasswordChangesTest extends Unit
{
    public function testModelInstanceOf(): void
    {
        $class = $this->make(PasswordChanges::class);

        $this->assertInstanceOf(Model::class, $class);
    }
}
