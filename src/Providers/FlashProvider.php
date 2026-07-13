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
use Phalcon\Html\Escaper;

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
        $di->set($this->providerName, function () {
            $escaper = new Escaper();
            $flash = new Flash($escaper);
            $flash->setImplicitFlush(false);
            $flash->setCssClasses([
                'error'   => 'flash flash-error',
                'success' => 'flash flash-success',
                'notice'  => 'flash flash-notice',
                'warning' => 'flash flash-warning',
            ]);

            return $flash;
        });
    }
}
