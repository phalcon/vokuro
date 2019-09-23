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
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;

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
        $savePath = $di->getShared('config')->path('application.sessionSavePath');
        $handler  = new SessionAdapter([
            'savePath' => $savePath,
        ]);

        $di->set($this->providerName, function () use ($handler) {
            $session = new SessionManager();
            $session->setAdapter($handler);
            $session->start();

            return $session;
        });
    }
}
