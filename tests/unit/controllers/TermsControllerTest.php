<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Controllers;

use Codeception\Test\Unit;
use Phalcon\Mvc\Controller;
use Vokuro\Controllers\TermsController;

final class TermsControllerTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(TermsController::class);

        $this->assertInstanceOf(Controller::class, $class);
    }
}
