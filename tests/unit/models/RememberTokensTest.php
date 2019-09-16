<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Models;

use Codeception\Test\Unit;
use Phalcon\Mvc\Model;
use Vokuro\Models\RememberTokens;

final class RememberTokensTest extends Unit
{
    public function testModelInstanceOf(): void
    {
        $class = $this->make(RememberTokens::class);

        $this->assertInstanceOf(Model::class, $class);
    }
}
