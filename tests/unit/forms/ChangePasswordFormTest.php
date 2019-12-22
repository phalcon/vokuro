<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Forms;

use Codeception\Test\Unit;
use Phalcon\Forms\Form;
use Vokuro\Forms\ChangePasswordForm;

final class ChangePasswordFormTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(ChangePasswordForm::class);

        $this->assertInstanceOf(Form::class, $class);
    }
}
