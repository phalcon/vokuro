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

class DispatcherProvider extends AbstractProvider
{
    protected $providerName = 'dispatcher';

    public function register(): void
    {
        // TODO
        $this->di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('Vokuro\Controllers');
            return $dispatcher;
        });
    }
}