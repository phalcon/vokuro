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

use Phalcon\Config;
use Vokuro\Application;
use function Vokuro\container;

/**
 * Register the global configuration as config
 */
class ConfigProvider extends AbstractProvider
{
    protected $providerName = 'config';

    public function register(): void
    {
        /** @var Application $application */
        $application = container(Application::APPLICATION_PROVIDER);
        /** @var string $rootPath */
        $rootPath = $application->getRootPath();
        $this->di->setShared($this->providerName, function () use ($rootPath) {
            $config = include $rootPath . '/configs/config.php';

            return new Config($config);
        });
    }
}
