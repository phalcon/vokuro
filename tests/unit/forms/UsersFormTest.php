<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Forms;

use Codeception\Test\Unit;
use Phalcon\Forms\Form;
use Vokuro\Forms\UsersForm;

final class UsersFormTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(UsersForm::class);

        $this->assertInstanceOf(Form::class, $class);
    }
}
