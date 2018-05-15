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
use Phalcon\Mvc\Model\Relation;

/**
 * All the profile levels in the application. Used in conjenction with ACL lists
 * Vokuro\Models\Profiles
 * @method static Profiles findFirstById($id)
 * @package Vokuro\Models
 */
class Profiles extends Model
{
    /** @var integer */
    public $id;

    /** @var string */
    public $name;

    /**
     * Define relationships to Users and Permissions
     */
    public function initialize()
    {
        $this->hasMany('id', __NAMESPACE__ . '\Users', 'profilesId', [
            'alias' => 'users',
            'foreignKey' => [
                'message' => 'Profile cannot be deleted because it\'s used on Users'
            ]
        ]);

        $this->hasMany('id', __NAMESPACE__ . '\Permissions', 'profilesId', [
            'alias' => 'permissions',
            'foreignKey' => [
                'action' => Relation::ACTION_CASCADE
            ]
        ]);
    }
}
