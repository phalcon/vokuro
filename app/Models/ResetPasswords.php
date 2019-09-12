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
 * ResetPasswords
 * Stores the reset password codes and their evolution
 *
 * @method static ResetPasswords findFirstByCode(string $code)
 */
class ResetPasswords extends Model
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
    public $reset;

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
        $this->reset = 'N';
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
     * Send an e-mail to users allowing him/her to reset his/her password
     */
    public function afterCreate()
    {
        $this->getDI()
             ->getMail()
             ->send([
                 $this->user->email => $this->user->name,
             ], "Reset your password", 'reset', [
                 'resetUrl' => '/reset-password/' . $this->code . '/' . $this->user->email,
             ])
        ;
    }
}
