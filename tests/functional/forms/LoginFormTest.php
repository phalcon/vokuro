<?php
declare(strict_types=1);

namespace Vokuro\Tests\Functional\Forms;

use Codeception\Test\Unit;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Vokuro\Forms\LoginForm;
use Vokuro\Providers\SecurityProvider;
use function Vokuro\container;

final class LoginFormTest extends Unit
{
    const EMAIL_KEY = 'email';
    const PASS_KEY = 'password';
    const CSRF_KEY = 'csrf';

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        $di = new FactoryDefault();
        $securityProvider = new SecurityProvider();
        $securityProvider->register($di);

        $emptyData = [];
        $incorrectCsrfData = [
            self::EMAIL_KEY => 'bob@phalcon.io',
            self::PASS_KEY => 'password1',
            self::CSRF_KEY => 'invalid',
        ];

        return [
            [$emptyData, 4, false],
            [$incorrectCsrfData, 1, false],
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
        $form = new LoginForm();
        $isValid = $form->isValid($data);
        $messages = $form->getMessages();

        $this->assertEquals($expected, $isValid);
        $this->assertEquals($errorsCount, count($messages));
    }
}
