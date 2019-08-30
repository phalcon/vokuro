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

namespace Vokuro\Providers;

use Vokuro\Plugins\Auth\Auth;

class AuthProvider extends AbstractProvider
{
    protected $providerName = 'auth';

    public function register(): void
    {
        $this->di->setShared($this->providerName, function () {
            return new Auth();
        });
    }
}
