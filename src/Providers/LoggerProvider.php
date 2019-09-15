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
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Logger\Adapter\Stream as FileLogger;
use Phalcon\Logger\Formatter\Line as FormatterLine;

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
        $loggerConfigs = $di->getShared('config')->get('logger');

        $di->set($this->providerName, function () use ($loggerConfigs) {
            $filename = trim($loggerConfigs->get('filename'), '\\/');
            $path     = rtrim($loggerConfigs->get('path'), '\\/') . DIRECTORY_SEPARATOR;

            $formatter = new FormatterLine($loggerConfigs->get('format'), $loggerConfigs->get('date'));
            $logger    = new FileLogger($path . $filename);

            $logger->setFormatter($formatter);

            return $logger;
        });
    }
}
