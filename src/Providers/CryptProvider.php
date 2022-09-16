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
use Phalcon\Encryption\Crypt;

class CryptProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected string $providerName = 'crypt';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var string $cryptSalt */
        $cryptSalt = $di->getShared('config')
                        ->path('application.cryptSalt')
        ;

        $di->set(
            $this->providerName,
            function () use ($cryptSalt) {
                $crypt = new Crypt();
                $crypt->setKey($cryptSalt);

                return $crypt;
            }
        );
    }
}
