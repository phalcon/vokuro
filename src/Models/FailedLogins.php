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
 * This model registers unsuccessfully logins registered and non-registered
 * users have made
 */
class FailedLogins extends Model
{
    /**
     * @var integer
     */
    public $attempted;
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $ipAddress;

    /**
     * @var integer
     */
    public $usersId;

    public function initialize(): void
    {
        $this->belongsTo('usersId', Users::class, 'id', [
            'alias' => 'user',
        ]);
    }
}
