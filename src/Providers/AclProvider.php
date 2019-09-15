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

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Vokuro\Application;
use Vokuro\Plugins\Acl\Acl;

class AclProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'acl';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var Application $application */
        $application = $di->getShared(Application::APPLICATION_PROVIDER);
        /** @var string $rootPath */
        $rootPath = $application->getRootPath();

        $di->setShared($this->providerName, function () use ($rootPath) {
            $filename         = $rootPath . '/config/acl.php';
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
