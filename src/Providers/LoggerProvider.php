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

use Phalcon\Config\Config;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;
use Phalcon\Logger\Logger;

/**
 * Logger service
 */
class LoggerProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'logger';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var Config $loggerConfigs */
        $loggerConfigs = $di->getShared('config')
                            ->get('logger')
        ;

        $di->set(
            $this->providerName,
            function () use ($loggerConfigs) {
                $filename  = trim($loggerConfigs->get('filename'), '\\/');
                $path      = rtrim($loggerConfigs->get('path'), '\\/') . DIRECTORY_SEPARATOR;
                $adapter   = new Stream($path . $filename);
                $formatter = new Line(
                    $loggerConfigs->get('format'),
                    $loggerConfigs->get('date')
                );
                $adapter->setFormatter($formatter);

                return new Logger('vokuro-logger', ['main' => $adapter]);
            }
        );
    }
}
