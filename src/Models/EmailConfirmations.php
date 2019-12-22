<?php
declare(strict_types=1);

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

/**
 * EmailConfirmations
 * Stores the reset password codes and their evolution
 *
 * @method static EmailConfirmations findFirstByCode(string $code)
 * @property Users $user
 */
class EmailConfirmations extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $usersId;

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
    public $modifiedAt;

    /**
     * @var string
     */
    public $confirmed;

    public function initialize()
    {
        $this->belongsTo('usersId', Users::class, 'id', [
            'alias' => 'user',
        ]);
    }

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        // Timestamp the confirmation
        $this->createdAt = time();

        // Generate a random confirmation code
        $this->code = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));

        // Set status to non-confirmed
        $this->confirmed = 'N';
    }

    /**
     * Sets the timestamp before update the confirmation
     */
    public function beforeValidationOnUpdate()
    {
        // Timestamp the confirmation
        $this->modifiedAt = time();
    }

    /**
     * Send a confirmation e-mail to the user after create the account
     */
    public function afterCreate()
    {
        $this->getDI()
             ->getMail()
             ->send([
                 $this->user->email => $this->user->name,
             ], "Please confirm your email", 'confirmation', [
                 'confirmUrl' => '/confirm/' . $this->code . '/' . $this->user->email,
             ])
        ;
    }
}
