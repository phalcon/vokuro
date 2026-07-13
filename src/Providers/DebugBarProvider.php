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

namespace Vokuro\Providers;

use Phalcon\DebugBar\Provider as DebugBar;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Events\ManagerInterface;
use Vokuro\Application;

class DebugBarProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var Application $bootstrap */
        $bootstrap = $di->getShared(Application::APPLICATION_PROVIDER);

        /** @var ManagerInterface $eventsManager */
        $eventsManager = $di->getShared('eventsManager');

        $app = $bootstrap->getApplication();
        $app->setEventsManager($eventsManager);

        (new DebugBar($app))->boot();
    }
}
