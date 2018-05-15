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
 * RememberTokens. Stores the remember me tokens
 * Vokuro\Models\RememberTokens
 * @package Vokuro\Models
 */
class RememberTokens extends Model
{
    /** @var integer */
    public $id;

    /** @var integer */
    public $usersId;

    /** @var string */
    public $token;

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
