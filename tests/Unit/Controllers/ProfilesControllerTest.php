<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vokuro\Tests\Unit\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Controllers\ProfilesController;

final class ProfilesControllerTest extends AbstractUnitTestCase
{
    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(ProfilesController::class);

        $this->assertInstanceOf(Controller::class, $class);
    }
}
