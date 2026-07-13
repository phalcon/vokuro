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

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Events\ManagerInterface;
use Phalcon\Mvc\Router;
use Vokuro\Application;
use Vokuro\Exception;

class RouterProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'router';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var Application $application */
        $application = $di->getShared(Application::APPLICATION_PROVIDER);
        /** @var string $basePath */
        $basePath = $application->getRootPath();

        $di->set($this->providerName, function () use ($basePath, $di) {
            $router = new Router();

            /** @var ManagerInterface $eventsManager */
            $eventsManager = $di->getShared('eventsManager');
            $router->setEventsManager($eventsManager);

            $routes = $basePath . '/config/routes.php';
            if (!file_exists($routes) || !is_readable($routes)) {
                throw new Exception($routes . ' file does not exist or is not readable.');
            }

            require $routes;

            return $router;
        });
    }
}
