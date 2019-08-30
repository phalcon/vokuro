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

class AclProvider extends AbstractProvider
{
    protected $providerName = 'acl';

    public function register(): void
    {
        // TODO
        $this->di->set('acl', function () {
            $pr = [];
            if (is_readable(APP_PATH . '/config/privateResources.php')) {
                $pr = include APP_PATH . '/config/privateResources.php';
            }

            $acl = new Acl();
            $acl->addPrivateResources($pr);
            return $acl;
        });
    }
}
