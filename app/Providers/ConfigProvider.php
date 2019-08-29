<?php
declare(strict_types=1);

namespace Vokuro\Providers;

class ConfigProvider extends AbstractProvider
{
    protected $providerName = 'config';

    public function register(): void
    {
        // TODO: refactor
        $this->di->setShared('config', function () {
            $config = include APP_PATH . '/config/config.php';

            if (is_readable(APP_PATH . '/config/config.dev.php')) {
                $override = include APP_PATH . '/config/config.dev.php';
                $config->merge($override);
            }

            return $config;
        });
    }
}
