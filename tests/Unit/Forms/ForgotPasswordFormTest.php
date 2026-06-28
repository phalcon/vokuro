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
use PHPUnit\Framework\Attributes\DataProvider;
use Vokuro\Forms\ForgotPasswordForm;

final class ForgotPasswordFormTest extends AbstractUnitTestCase
{
    private const EMAIL_KEY = 'email';

    public static function dataProvider(): array
    {
        return [
            [[], 2, false],
            [[self::EMAIL_KEY => 'invalid email'], 1, false],
            [[self::EMAIL_KEY => 'valid@email.com'], 0, true],
            [[self::EMAIL_KEY => 'sarah.connor@skynet.dev'], 0, true],
        ];
    }

    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(ForgotPasswordForm::class);

        $this->assertInstanceOf(Form::class, $class);
    }

    #[DataProvider('dataProvider')]
    public function testValidations(array $data, int $errorsCount, bool $expected): void
    {
        $form     = new ForgotPasswordForm();
        $isValid  = $form->isValid($data);
        $messages = $form->getMessages();

        $this->assertEquals($expected, $isValid);
        $this->assertEquals($errorsCount, count($messages));
    }
}
