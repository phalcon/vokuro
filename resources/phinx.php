<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

return [
    'paths' => [
        'migrations' => [
            'Vokuro\\Migrations' => '%%PHINX_CONFIG_DIR%%/migrations',
        ],
        'seeds' => [
            'Vokuro\\Seeds' => '%%PHINX_CONFIG_DIR%%/seeds',
        ],
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => strtolower((string) getenv('DB_ADAPTER')),
            'host' => getenv('DB_HOST'),
            'name' => strtolower((string) getenv('DB_ADAPTER')) === 'sqlite'
                ? '%%PHINX_CONFIG_DIR%%/../var/' . getenv('DB_NAME')
                : getenv('DB_NAME'),
            'user' => getenv('DB_USERNAME'),
            'pass' => getenv('DB_PASSWORD'),
            'port' => getenv('DB_PORT'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ],
    'version_order' => 'creation',
];
