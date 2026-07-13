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
use Phalcon\Db\Adapter\AbstractAdapter;
use Phalcon\Db\Adapter\Pdo;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Events\ManagerInterface;
use Vokuro\Exception;

use function Vokuro\root_path;

class DbProvider implements ServiceProviderInterface
{
    /**
     * Class map of database adapters, indexed by PDO::ATTR_DRIVER_NAME.
     *
     * @var array<string, class-string>
     */
    protected array $adapters = [
        'mysql'  => Pdo\Mysql::class,
        'pgsql'  => Pdo\Postgresql::class,
        'sqlite' => Pdo\Sqlite::class,
    ];
    /**
     * @var string
     */
    protected string $providerName = 'db';


    /**
     * @param DiInterface $di
     *
     * @return void
     * @throws Exception
     */
    public function register(DiInterface $di): void
    {
        /** @var Config $config */
        $config = $di->getShared('config')->get('database');
        $class  = $this->getClass($config);
        $config = $this->createConfig($config);

        $di->set($this->providerName, function () use ($class, $config, $di) {
            /** @var ManagerInterface $eventsManager */
            $eventsManager = $di->getShared('eventsManager');

            /** @var AbstractAdapter $connection */
            $connection = new $class($config);
            $connection->setEventsManager($eventsManager);

            return $connection;
        });
    }

    /**
     * @param Config $config
     *
     * @return array<string, mixed>
     */
    private function createConfig(Config $config): array
    {
        // To prevent error: SQLSTATE[08006] [7] invalid connection option "adapter"
        $dbConfig = $config->toArray();
        unset($dbConfig['adapter']);

        $name = $config->get('adapter');
        switch ($this->adapters[$name]) {
            case Pdo\Sqlite::class:
                // Resolve database path
                $dbConfig = ['dbname' => root_path("var/{$config->get('dbname')}.sqlite3")];
                break;
            case Pdo\Postgresql::class:
                // Postgres does not allow the charset to be changed in the DSN.
                unset($dbConfig['charset']);
                break;
            default:
                // MySQL (and any other adapter) needs no DSN adjustments.
                break;
        }

        return $dbConfig;
    }

    /**
     * Get an adapter class by name.
     *
     * @param Config $config
     *
     * @return string
     * @throws Exception
     */
    private function getClass(Config $config): string
    {
        $name = $config->get('adapter', 'Unknown');

        if (empty($this->adapters[$name])) {
            throw new Exception(
                sprintf(
                    'Adapter "%s" has not been registered',
                    $name
                )
            );
        }

        return $this->adapters[$name];
    }
}
