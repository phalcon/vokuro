<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Controllers;

use Codeception\Test\Unit;
use Phalcon\Mvc\Controller;
use Vokuro\Controllers\UsersController;

final class UsersControllerTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(UsersController::class);

        $this->assertInstanceOf(Controller::class, $class);
    }
}
