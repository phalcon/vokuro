<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Controllers;

use Codeception\Test\Unit;
use Phalcon\Mvc\Controller;
use Vokuro\Controllers\ControllerBase;

final class ControllerBaseTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(ControllerBase::class);

        $this->assertInstanceOf(Controller::class, $class);
    }
}
