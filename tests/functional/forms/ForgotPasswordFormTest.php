<?php
declare(strict_types=1);

namespace Vokuro\Tests\Functional\Forms;

use Codeception\Test\Unit;
use Vokuro\Forms\ForgotPasswordForm;

final class ForgotPasswordFormTest extends Unit
{
    const EMAIL_KEY = 'email';

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [[], 2, false],
            [[self::EMAIL_KEY => 'invalid email'], 1, false],
            [[self::EMAIL_KEY => 'valid@email.com'], 0, true],
            [[self::EMAIL_KEY => 'bob@phalcon.io'], 0, true],
        ];
    }

    /**
     * @dataProvider dataProvider
     *
     * @param array $data
     * @param int $errorsCount
     * @param bool $expected
     */
    public function testValidations(array $data, int $errorsCount, bool $expected): void
    {
        $form = new ForgotPasswordForm();
        $isValid = $form->isValid($data);
        $messages = $form->getMessages();

        $this->assertEquals($expected, $isValid);
        $this->assertEquals($errorsCount, count($messages));
    }
}
