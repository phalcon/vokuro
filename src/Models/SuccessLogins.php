<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

/**
 * SuccessLogins
 *
 * This model registers successfully logins registered users have made
 */
class SuccessLogins extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $ipAddress;

    /**
     * @var string
     */
    public $userAgent;

    /**
     * @var integer
     */
    public $usersId;

    public function initialize()
    {
        $this->belongsTo('usersId', Users::class, 'id', [
            'alias' => 'user',
        ]);
    }
}
