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
use Phalcon\Encryption\Security;

class SecurityProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected string $providerName = 'security';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->set(
            $this->providerName,
            function () use ($di) {
                $security = new Security();
                $security->setDI($di);

                return $security;
            }
        );
    }
}
