<?php
declare(strict_types=1);

use Codeception\Stub;
use Codeception\Test\Unit;
use Phalcon\Mvc\Model;
use Vokuro\Models\EmailConfirmations;

final class EmailConfirmationsTest extends Unit
{
    public function testModelInstanceOf(): void
    {
        $emailConfirmations = Stub::make(EmailConfirmations::class);

        $this->assertInstanceOf(Model::class, $emailConfirmations);
    }
}
