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
use Phalcon\Session\Adapter\Beta2FixStream;
use Phalcon\Session\Adapter\Noop;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;
use Phalcon\Version;
use function Vokuro\config;

class SessionProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'session';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var string $savePath */
        $savePath = config('application.sessionSavePath');
        $handler  = $this->getSessionAdapter($savePath);

        $di->set($this->providerName, function () use ($handler) {
            $session = new SessionManager();
            $session->setHandler($handler);
            $session->start();

            return $session;
        });
    }

    /**
     * Remove current method after after next release of Phalcon 4
     *
     * @see https://github.com/phalcon/cphalcon/issues/14265
     *
     * @param string $savePath
     *
     * @return Noop
     */
    protected function getSessionAdapter(string $savePath): Noop
    {
        $options = [
            'savePath' => $savePath,
        ];

        if (Version::get() !== '4.0.0-beta.2') {
            return new SessionAdapter($options);
        }

        return new Beta2FixStream($options);
    }
}
