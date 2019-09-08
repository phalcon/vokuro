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
use Phalcon\Db\Adapter\Pdo;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use RuntimeException;
use function Vokuro\config;

class DbProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'db';

    /**
     * Class map of database adapters, indexed by PDO::ATTR_DRIVER_NAME.
     *
     * @var array
     */
    protected $adapters = [
        'mysql' => Pdo\Mysql::class,
        'pgsql' => Pdo\Postgresql::class,
        'sqlite' => Pdo\Sqlite::class,
    ];


    /**
     * @param DiInterface $di
     * @return void
     * @throws RuntimeException
     */
    public function register(DiInterface $di): void
    {
        $that = $this;
        $di->set($this->providerName, function () use ($that) {
            $config = config('database');
            $class = $that->getClass($config);

            // To prevent Postgresql error: SQLSTATE[08006] [7] invalid connection option "adapter"
            $dbConfig = $config->toArray();
            unset($dbConfig['adapter']);

            return new $class($dbConfig);
        });
    }

    /**
     * Get an adapter class by name.
     *
     * @param Config $config
     * @return string
     * @throws RuntimeException
     */
    private function getClass(Config $config): string
    {
        $name = $config->get('adapter', 'Unknown');

        if (empty($this->adapters[$name])) {
            throw new RuntimeException(
                sprintf(
                    'Adapter "%s" has not been registered',
                    $name
                )
            );
        }

        return $this->adapters[$name];
    }
}
