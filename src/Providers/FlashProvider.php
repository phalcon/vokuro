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
use Phalcon\Flash\Direct as Flash;

class FlashProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected string $providerName = 'flash';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $escaper = $di->getShared('escaper');
        $di->set(
            $this->providerName,
            function () use ($escaper) {
                $flash = new Flash($escaper);
                $flash->setImplicitFlush(false);
                $flash->setCssClasses(
                    [
                        'error'   => 'alert alert-danger',
                        'success' => 'alert alert-success',
                        'notice'  => 'alert alert-info',
                        'warning' => 'alert alert-warning',
                    ]
                );

                return $flash;
            }
        );
    }
}
