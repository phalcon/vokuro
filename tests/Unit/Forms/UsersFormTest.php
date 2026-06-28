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

namespace Vokuro\Tests\Unit\Forms;

use Phalcon\Forms\Form;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Forms\UsersForm;

final class UsersFormTest extends AbstractUnitTestCase
{
    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(UsersForm::class);

        $this->assertInstanceOf(Form::class, $class);
    }
}
