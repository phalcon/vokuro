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
use Vokuro\Forms\ProfilesForm;

final class ProfilesFormTest extends AbstractUnitTestCase
{
    private const NAME_KEY = 'name';

    public static function dataProvider(): array
    {
        return [
            [[], 1, false],
            [[self::NAME_KEY => ''], 1, false],
            [[self::NAME_KEY => 'valid name'], 0, true],
        ];
    }

    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(ProfilesForm::class);

        $this->assertInstanceOf(Form::class, $class);
    }

    #[DataProvider('dataProvider')]
    public function testValidations(array $data, int $errorsCount, bool $expected): void
    {
        $form     = new ProfilesForm();
        $isValid  = $form->isValid($data);
        $messages = $form->getMessages();

        $this->assertEquals($expected, $isValid);
        $this->assertEquals($errorsCount, count($messages));
    }
}
