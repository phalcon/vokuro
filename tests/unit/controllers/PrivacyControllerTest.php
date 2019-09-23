<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Controllers;

use Codeception\Test\Unit;
use Phalcon\Mvc\Controller;
use Vokuro\Controllers\PrivacyController;

final class PrivacyControllerTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(PrivacyController::class);

        $this->assertInstanceOf(Controller::class, $class);
    }
}
