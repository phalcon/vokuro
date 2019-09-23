<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Models;

use Codeception\Test\Unit;
use Phalcon\Mvc\Model;
use Vokuro\Models\EmailConfirmations;

final class EmailConfirmationsTest extends Unit
{
    public function testModelInstanceOf(): void
    {
        $class = $this->make(EmailConfirmations::class);

        $this->assertInstanceOf(Model::class, $class);
    }
}
