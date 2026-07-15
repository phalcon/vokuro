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
use Phalcon\DebugBar\Debug;
use Phalcon\DebugBar\Logger\Adapter as DebugBarAdapter;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Logger\Adapter\Stream as FileAdapter;
use Phalcon\Logger\Formatter\Line as FormatterLine;
use Phalcon\Logger\Logger;

/**
 * Logger service
 *
 * Wraps the adapters in a Phalcon\Logger\Logger so multiple adapters can be
 * attached: the file (Stream) adapter and the debug bar adapter, which streams
 * every logged item into the debug bar's "Logs" panel.
 */
class LoggerProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected string $providerName = 'logger';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var Config $loggerConfigs */
        $loggerConfigs = $di->getShared('config')->get('logger');

        $di->set(
            $this->providerName,
            function () use ($loggerConfigs) {
                $filename = trim($loggerConfigs->get('filename'), '\\/');
                $path     = rtrim($loggerConfigs->get('path'), '\\/') . DIRECTORY_SEPARATOR;

                $formatter = new FormatterLine(
                    $loggerConfigs->get('format'), $loggerConfigs->get('date')
                );

                $fileAdapter = new FileAdapter($path . $filename);
                $fileAdapter->setFormatter($formatter);

                return new Logger(
                    'vokuro',
                    [
                        'file'     => $fileAdapter,
                        'debugbar' => new DebugBarAdapter(Debug::getBar()),
                    ]
                );
            }
        );
    }
}
