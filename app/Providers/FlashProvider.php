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

use Phalcon\Flash\Direct as Flash;

class FlashProvider extends AbstractProvider
{
    protected $providerName = 'flash';

    public function register(): void
    {
        $this->di->set($this->providerName, function () {
            return new Flash([
                'error' => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice' => 'alert alert-info',
                'warning' => 'alert alert-warning'
            ]);
        });
    }
}
