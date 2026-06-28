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

use Phalcon\Di\FactoryDefault;
use Phalcon\Forms\Form;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Vokuro\Forms\LoginForm;
use Vokuro\Providers\SecurityProvider;

final class LoginFormTest extends AbstractUnitTestCase
{
    private const CSRF_KEY = 'csrf';
    private const EMAIL_KEY = 'email';
    private const PASS_KEY = 'password';

    public static function dataProvider(): array
    {
        $di = new FactoryDefault();
        $securityProvider = new SecurityProvider();
        $securityProvider->register($di);

        $emptyData = [];
        $incorrectCsrfData = [
            self::EMAIL_KEY => 'sarah.connor@skynet.dev',
            self::PASS_KEY => 'password1',
            self::CSRF_KEY => 'invalid',
        ];

        return [
            [$emptyData, 4, false],
            [$incorrectCsrfData, 1, false],
        ];
    }

    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(LoginForm::class);

        $this->assertInstanceOf(Form::class, $class);
    }

    #[DataProvider('dataProvider')]
    public function testValidations(array $data, int $errorsCount, bool $expected): void
    {
        $form     = new LoginForm();
        $isValid  = $form->isValid($data);
        $messages = $form->getMessages();

        $this->assertEquals($expected, $isValid);
        $this->assertEquals($errorsCount, count($messages));
    }
}
