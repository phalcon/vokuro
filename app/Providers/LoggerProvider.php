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

class LoggerProvider extends AbstractProvider
{
    protected $providerName = 'logger';

    public function register(): void
    {
        // TODO
        $this->di->set('logger', function ($filename = null, $format = null) {
            $config = $this->getConfig();

            $format = $format ?: $config->get('logger')->format;
            $filename = trim($filename ?: $config->get('logger')->filename, '\\/');
            $path = rtrim($config->get('logger')->path, '\\/') . DIRECTORY_SEPARATOR;

            $formatter = new FormatterLine($format, $config->get('logger')->date);
            $logger = new FileLogger($path . $filename);

            $logger->setFormatter($formatter);
            $logger->setLogLevel($config->get('logger')->logLevel);

            return $logger;
        });
    }
}
