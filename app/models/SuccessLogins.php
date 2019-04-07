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
    public $userID;

    /**
     *
     * @var string
     */
    public $ipAddress;

    /**
     *
     * @var string
     */
    public $userAgent;

    /**
     *
     * @var string
     */
    public $date;

    public function initialize()
    {
        $this->belongsTo('userID', __NAMESPACE__ . '\Users', 'id', [
            'alias' => 'user'
        ]);
    }
}
