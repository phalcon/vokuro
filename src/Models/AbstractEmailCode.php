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

use Phalcon\Mvc\Model;
use Vokuro\Plugins\Mail\Mail;

/**
 * A single use code that is generated for a user and e-mailed to them
 *
 * @property Users $user
 */
abstract class AbstractEmailCode extends Model
{
    /**
     * @var string
     */
    public $code;

    /**
     * @var integer
     */
    public $createdAt;

    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $modifiedAt;

    /**
     * @var integer
     */
    public $usersId;

    /**
     * Send the code to the user after the record is created
     */
    public function afterCreate(): void
    {
        /** @var Mail $mail */
        $mail = $this->getDI()->get('mail');
        $mail->send(
            [
                $this->user->email => $this->user->name,
            ],
            $this->getMailSubject(),
            $this->getMailTemplate(),
            $this->getMailParameters()
        );
    }

    /**
     * Timestamps the record and generates a random code before it is created
     */
    public function beforeValidationOnCreate(): void
    {
        // Timestamp the code
        $this->createdAt = time();

        // Generate a random code
        $this->code = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));
    }

    /**
     * Sets the timestamp before update the confirmation
     */
    public function beforeValidationOnUpdate(): void
    {
        // Timestamp the confirmation
        $this->modifiedAt = time();
    }

    public function initialize(): void
    {
        $this->belongsTo('usersId', Users::class, 'id', [
            'alias' => 'user',
        ]);
    }

    /**
     * The parameters passed to the e-mail template
     *
     * @return array<string, string>
     */
    abstract protected function getMailParameters(): array;

    /**
     * The subject of the e-mail sent to the user
     */
    abstract protected function getMailSubject(): string;

    /**
     * The name of the e-mail template sent to the user
     */
    abstract protected function getMailTemplate(): string;
}
