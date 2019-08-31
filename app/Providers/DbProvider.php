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
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use function Vokuro\config;

class DbProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'db';

    /**
     * @param DiInterface $di
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var Config $dbConfig */
        $dbConfig = config('database');

        $di->set($this->providerName, function () use ($dbConfig) {
            return new DbAdapter([
                'host' => $dbConfig->get('host'),
                'username' => $dbConfig->get('username'),
                'password' => $dbConfig->get('password'),
                'dbname' => $dbConfig->get('dbname'),
            ]);
        });
    }
}
