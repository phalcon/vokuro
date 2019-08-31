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

use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;
use function Vokuro\config;

class SessionProvider extends AbstractProvider
{
    protected $providerName = 'session';

    public function register(): void
    {
        $savePath = config('application.sessionSavePath');
        $this->di->set($this->providerName, function () use ($savePath) {
            $files = new SessionAdapter([
                'savePath' => $savePath,
            ]);

            $session = new SessionManager();
            $session->setHandler($files);
            $session->start();

            return $session;
        });
    }
}
