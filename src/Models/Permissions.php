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
 * Permissions
 *
 * Stores the permissions by profile
 */
class Permissions extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $profilesId;

    /**
     * @var string
     */
    public $resource;

    /**
     * @var string
     */
    public $action;

    public function initialize()
    {
        $this->belongsTo('profilesId', Profiles::class, 'id', [
            'alias' => 'profile',
        ]);
    }
}
