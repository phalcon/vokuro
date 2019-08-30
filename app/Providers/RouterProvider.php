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

class RouterProvider extends AbstractProvider
{
    protected $providerName = 'router';

    public function register(): void
    {
        // TODO
        $this->di->set('router', function () {
            return require APP_PATH . '/config/routes.php';
        });
    }
}
