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
use Phalcon\Mvc\Model\Relation;

/**
 * Vokuro\Models\Profiles
 * All the profile levels in the application. Used in conjenction with ACL lists
 */
class Profiles extends Model
{
    /**
     * ID
     *
     * @var integer
     */
    public $id;

    /**
     * Name
     *
     * @var string
     */
    public $name;

    /**
     * Define relationships to Users and Permissions
     */
    public function initialize()
    {
        $this->hasMany('id', Users::class, 'profilesId', [
            'alias'      => 'users',
            'foreignKey' => [
                'message' => 'Profile cannot be deleted because it\'s used on Users',
            ],
        ]);

        $this->hasMany('id', Permissions::class, 'profilesId', [
            'alias'      => 'permissions',
            'foreignKey' => [
                'action' => Relation::ACTION_CASCADE,
            ],
        ]);
    }
}
