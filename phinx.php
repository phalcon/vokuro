<?php

use Dotenv\Dotenv;

(Dotenv::createImmutable(__DIR__))->load();

$adapter = strtolower($_ENV['DB_ADAPTER'] ?? 'mysql');
$host    = $_ENV['DB_HOST'] ?? 'localhost';
$user    = $_ENV['DB_USERNAME'] ?? 'root';
$pass    = $_ENV['DB_PASSWORD'] ?? '';
$port    = $_ENV['DB_PORT'] ?? 3306;
$name    = $_ENV['DB_NAME'] ?? 'phalcon_vokuro';

if ('sqlite' === $adapter) {
    $name = '%%PHINX_CONFIG_DIR%%/db/' . $name;
}

return [
    'paths'         => [
        'migrations' => [
            'Vokuro\\Migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations'
        ],
        'seeds'      => [
            'Vokuro\\Seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds',
        ],
    ],
    'environments'  => [
        'default_migration_table' => 'phinxlog',
        'default_database'        => 'development',
        'development'             => [
            'adapter'   => $adapter,
            'host'      => $host,
            'name'      => $name,
            'user'      => $user,
            'pass'      => $pass,
            'port'      => $port,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ],
    'version_order' => 'creation'
];
