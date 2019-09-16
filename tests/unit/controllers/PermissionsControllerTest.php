<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Controllers;

use Codeception\Test\Unit;
use Phalcon\Mvc\Controller;
use Vokuro\Controllers\PermissionsController;

final class PermissionsControllerTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(PermissionsController::class);

        $this->assertInstanceOf(Controller::class, $class);
    }
}
