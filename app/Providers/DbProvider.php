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
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use function Vokuro\config;

class DbProvider extends AbstractProvider
{
    protected $providerName = 'db';

    public function register(): void
    {
        /** @var Config $dbConfig */
        $dbConfig = config('database');
        $this->di->set($this->providerName, function () use ($dbConfig) {
            return new DbAdapter([
                'host' => $dbConfig->host,
                'username' => $dbConfig->username,
                'password' => $dbConfig->password,
                'dbname' => $dbConfig->dbname
            ]);
        });
    }
}
