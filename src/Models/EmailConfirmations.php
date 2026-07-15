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
 * EmailConfirmations
 * Stores the reset password codes and their evolution
 *
 * @method static EmailConfirmations findFirstByCode(string $code)
 */
class EmailConfirmations extends AbstractEmailCode
{
    /**
     * @var string
     */
    public $confirmed;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate(): void
    {
        parent::beforeValidationOnCreate();

        // Set status to non-confirmed
        $this->confirmed = 'N';
    }

    /**
     * @return array<string, string>
     */
    protected function getMailParameters(): array
    {
        return [
            'confirmUrl' => '/confirm/' . $this->code . '/' . $this->user->email,
        ];
    }

    protected function getMailSubject(): string
    {
        return 'Please confirm your email';
    }

    protected function getMailTemplate(): string
    {
        return 'confirmation';
    }
}
