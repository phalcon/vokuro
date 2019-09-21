<?php
declare(strict_types=1);

namespace Vokuro\Tests\Functional\Forms;

use Codeception\Test\Unit;
use Vokuro\Forms\ChangePasswordForm;

final class ChangePasswordFormTest extends Unit
{
    const PASS_KEY = 'password';
    const CONFIRM_PASS_KEY = 'confirmPassword';

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        $emptyData = [];
        $emptyPasswordData = [
            self::PASS_KEY => '',
            self::CONFIRM_PASS_KEY => '',
        ];
        $shortPasswordData = [
            self::PASS_KEY => '123',
            self::CONFIRM_PASS_KEY => '123',
        ];
        $emptyConfirmPasswordData = [
            self::PASS_KEY => 'valid password empty config',
        ];
        $missMatchConfigPasswordData = [
            self::PASS_KEY => '123456780',
            self::CONFIRM_PASS_KEY => '123456789',
        ];
        $correctData1 = [
            self::PASS_KEY => '12345678',
            self::CONFIRM_PASS_KEY => '12345678',
        ];
        $correctData2 = [
            self::PASS_KEY => 'valid password',
            self::CONFIRM_PASS_KEY => 'valid password'
        ];
        $correctData3 = [
            self::PASS_KEY => '(*%^%$#@#$%^',
            self::CONFIRM_PASS_KEY => '(*%^%$#@#$%^',
        ];

        return [
            [$emptyData, 3, false],
            [$emptyPasswordData, 3, false],
            [$shortPasswordData, 1, false],
            [$emptyConfirmPasswordData, 2, false],
            [$missMatchConfigPasswordData, 1, false],
            [$correctData1, 0, true],
            [$correctData2, 0, true],
            [$correctData3, 0, true],
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
        $form = new ChangePasswordForm();
        $isValid = $form->isValid($data);
        $messages = $form->getMessages();

        $this->assertEquals($expected, $isValid);
        $this->assertEquals($errorsCount, count($messages));
    }
}
