<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Controllers;

use Codeception\Test\Unit;
use Phalcon\Mvc\Controller;
use Vokuro\Controllers\SessionController;

final class SessionControllerTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(SessionController::class);

        $this->assertInstanceOf(Controller::class, $class);
    }
}
