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

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use function Vokuro\config;

class ViewProvider extends AbstractProvider
{
    protected $providerName = 'view';

    public function register(): void
    {
        /** @var string $viewsDir */
        $viewsDir = config('application.viewsDir');
        /** @var string $cacheDir */
        $cacheDir = config('application.cacheDir');

        $this->di->setShared($this->providerName, function () use ($viewsDir, $cacheDir) {
            $view = new View();
            $view->setViewsDir($viewsDir);
            $view->registerEngines([
                '.volt' => function ($view) use ($cacheDir) {
                    $volt = new Volt($view, $this);
                    $volt->setOptions([
                        'path' => $cacheDir . 'volt/',
                        'separator' => '_'
                    ]);

                    return $volt;
                }
            ]);

            return $view;
        });
    }
}
