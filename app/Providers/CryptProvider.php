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

use Phalcon\Crypt;
use function Vokuro\config;

class CryptProvider extends AbstractProvider
{
    protected $providerName = 'crypt';

    public function register(): void
    {
        /** @var string $cryptSalt */
        $cryptSalt = config('application.cryptSalt');
        $this->di->set($this->providerName, function () use ($cryptSalt) {
            $crypt = new Crypt();
            $crypt->setKey($cryptSalt);

            return $crypt;
        });

    }
}
