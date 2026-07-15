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

namespace Vokuro\Models;

/**
 * ResetPasswords
 * Stores the reset password codes and their evolution
 *
 * @method static ResetPasswords findFirstByCode(string $code)
 */
class ResetPasswords extends AbstractEmailCode
{
    /**
     * @var string
     */
    public $reset;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate(): void
    {
        parent::beforeValidationOnCreate();

        // Set status to non-confirmed
        $this->reset = 'N';
    }

    /**
     * @return array<string, string>
     */
    protected function getMailParameters(): array
    {
        return [
            'resetUrl' => '/reset-password/' . $this->code . '/' . $this->user->email,
        ];
    }

    protected function getMailSubject(): string
    {
        return 'Reset your password';
    }

    protected function getMailTemplate(): string
    {
        return 'reset';
    }
}
