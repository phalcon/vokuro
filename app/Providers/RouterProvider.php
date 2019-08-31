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

use Vokuro\Application;
use function Vokuro\container;

class RouterProvider extends AbstractProvider
{
    protected $providerName = 'router';

    public function register(): void
    {
        /** @var Application $application */
        $application = container(Application::APPLICATION_PROVIDER);
        /** @var string $basePath */
        $basePath = $application->getRootPath();
        $this->di->set($this->providerName, function () use ($basePath) {
            return require $basePath . '/configs/routes.php';
        });
    }
}
