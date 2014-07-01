<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;

/**
 * SuccessLogins
 * This model registers successfull logins registered users have made
 */
class SuccessLogins extends Model
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

    /**
     *
     * @var string
     */
    public $ip_address;

    /**
     *
     * @var string
     */
    public $user_agent;

    public function initialize()
    {
        $this->belongsTo('user_id', 'Vokuro\Models\Users', 'id', array(
            'alias' => 'user'
        ));
    }
}
