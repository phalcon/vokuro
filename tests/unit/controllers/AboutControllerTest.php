<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Controllers;

use Codeception\Test\Unit;
use Phalcon\Mvc\Controller;
use Vokuro\Controllers\AboutController;

final class AboutControllerTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(AboutController::class);

        $this->assertInstanceOf(Controller::class, $class);
    }
}
