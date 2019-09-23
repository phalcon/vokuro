<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Controllers;

use Codeception\Test\Unit;
use Phalcon\Mvc\Controller;
use Vokuro\Controllers\ProfilesController;

final class ProfilesControllerTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(ProfilesController::class);

        $this->assertInstanceOf(Controller::class, $class);
    }
}
