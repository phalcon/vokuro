<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;

/**
 * EmailConfirmations
 * Stores the reset password codes and their evolution
 */
class EmailConfirmations extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $user_id;

    public $code;

    /**
     *
     * @var integer
     */
    public $created_at;

    /**
     *
     * @var integer
     */
    public $modified_at;

    public $confirmed;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        // Timestamp the confirmaton
        $this->created_at = time();

        // Generate a random confirmation code
        $this->code = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));

        // Set status to non-confirmed
        $this->confirmed = 0;
    }

    /**
     * Sets the timestamp before update the confirmation
     */
    public function beforeValidationOnUpdate()
    {
        // Timestamp the confirmaton
        $this->modified_at = time();
    }

    /**
     * Send a confirmation e-mail to the user after create the account
     */
    public function afterCreate()
    {
        $this->getDI()
            ->getMail()
            ->send(array(
            $this->user->email => $this->user->name
        ), "Please confirm your email", 'confirmation', array(
            'confirmUrl' => '/confirm/' . $this->code . '/' . $this->user->email
        ));
    }

    public function initialize()
    {
        $this->belongsTo('user_id', 'Vokuro\Models\Users', 'id', array(
            'alias' => 'user'
        ));
    }
}
