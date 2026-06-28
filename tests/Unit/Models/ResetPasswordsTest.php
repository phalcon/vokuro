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

namespace Vokuro\Tests\Unit\Models;

use Phalcon\Mvc\Model;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Models\ResetPasswords;

final class ResetPasswordsTest extends AbstractUnitTestCase
{
    public function testModelInstanceOf(): void
    {
        $class = $this->mockWithoutConstructor(ResetPasswords::class);

        $this->assertInstanceOf(Model::class, $class);
    }
}
