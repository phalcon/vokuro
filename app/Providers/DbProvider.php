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

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

class DbProvider extends AbstractProvider
{
    protected $providerName = 'db';

    public function register(): void
    {
        // TODO
        $this->di->set('db', function () {
            $config = $this->getConfig();
            return new DbAdapter([
                'host' => $config->database->host,
                'username' => $config->database->username,
                'password' => $config->database->password,
                'dbname' => $config->database->dbname
            ]);
        });
    }
}
