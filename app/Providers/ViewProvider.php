<?php
declare(strict_types=1);

namespace Vokuro\Providers;

class ViewProvider extends AbstractProvider
{
    protected $providerName = 'view';

    public function register(): void
    {
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
