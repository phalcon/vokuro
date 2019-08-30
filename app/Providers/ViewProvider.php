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

class ViewProvider extends AbstractProvider
{
    protected $providerName = 'view';

    public function register(): void
    {
        // TODO
        $this->di->setShared('view', function () {
            $config = $this->getConfig();

            $view = new View();
            $view->setViewsDir($config->application->viewsDir);
            $view->registerEngines([
                '.volt' => function ($view) {
                    $config = $this->getConfig();
                    $volt = new VoltEngine($view, $this);
                    $volt->setOptions([
                        'path' => $config->application->cacheDir . 'volt/',
                        'separator' => '_'
                    ]);

                    return $volt;
                }
            ]);

            return $view;
        });
    }
}
