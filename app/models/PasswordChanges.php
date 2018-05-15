<?php

/*
  +------------------------------------------------------------------------+
  | Vökuró                                                                 |
  +------------------------------------------------------------------------+
  | Copyright (c) 2016-present Phalcon Team (https://www.phalconphp.com)   |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file LICENSE.txt.                             |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
*/

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

/**
 * PasswordChanges. Register when a user changes his/her password
 * Vokuro\Models\PasswordChanges
 * @package Vokuro\Models
 */
class PasswordChanges extends Model
{
    /** @var integer */
    public $id;

    /** @var integer */
    public $usersId;

    /** @var string */
    public $ipAddress;

    /** @var string */
    public $userAgent;

    /** @var integer */
    public $createdAt;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        // Timestamp the confirmaton
        $this->createdAt = time();
    }

    public function initialize()
    {
        $this->belongsTo('usersId', __NAMESPACE__ . '\Users', 'id', [
            'alias' => 'user'
        ]);
    }
}
