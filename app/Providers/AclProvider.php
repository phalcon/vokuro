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
use Vokuro\Plugins\Acl\Acl;
use function Vokuro\container;

class AclProvider extends AbstractProvider
{
    protected $providerName = 'acl';

    public function register(): void
    {
        /** @var Application $application */
        $application = container(Application::APPLICATION_PROVIDER);
        /** @var string $rootPath */
        $rootPath = $application->getRootPath();
        $this->di->setShared($this->providerName, function () use ($rootPath) {
            $filename = $rootPath . '/configs/acl.php';
            $privateResources = [];
            if (is_readable($filename)) {
                $privateResources = include $filename;
                if (!empty($privateResources['private'])) {
                    $privateResources = $privateResources['private'];
                }
            }

            $acl = new Acl();
            $acl->addPrivateResources($privateResources);

            return $acl;
        });
    }
}
