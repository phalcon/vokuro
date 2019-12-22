<?php
declare(strict_types=1);

namespace Vokuro\Tests\Functional\Forms;

use Codeception\Test\Unit;
use Vokuro\Forms\ProfilesForm;

final class ProfilesFormTest extends Unit
{
    const NAME_KEY = 'name';

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [[], 1, false],
            [[self::NAME_KEY => ''], 1, false],
            [[self::NAME_KEY => 'valid name'], 0, true],
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
        $form = new ProfilesForm();
        $isValid = $form->isValid($data);
        $messages = $form->getMessages();

        $this->assertEquals($expected, $isValid);
        $this->assertEquals($errorsCount, count($messages));
    }
}
