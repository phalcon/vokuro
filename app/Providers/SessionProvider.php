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

class SessionProvider extends AbstractProvider
{
    protected $providerName = 'session';

    public function register(): void
    {
        // TODO
        $this->di->set('session', function () {
            $config = $this->getConfig();

            $files = new SessionAdapter([
                'savePath' => $config->application->sessionSavePath,
            ]);
            $session = new SessionManager();
            $session->setHandler($files);
            $session->start();

            return $session;
        });
    }
}
