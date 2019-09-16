<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Models;

use Codeception\Test\Unit;
use Phalcon\Mvc\Model;
use Vokuro\Models\Profiles;

final class ProfilesTest extends Unit
{
    public function testModelInstanceOf(): void
    {
        $class = $this->make(Profiles::class);

        $this->assertInstanceOf(Model::class, $class);
    }
}
