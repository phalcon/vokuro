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

use Phalcon\Logger\Enum;

use function Vokuro\root_path;

return [
    'database'    => [
        'adapter'  => $_ENV['DB_ADAPTER'] ?? 'mysql',
        'host'     => $_ENV['DB_HOST'] ?? '127.0.0.1',
        'port'     => $_ENV['DB_PORT'] ?? 3306,
        'username' => $_ENV['DB_USERNAME'] ?? 'root',
        'password' => $_ENV['DB_PASSWORD'] ?? 'secret',
        'dbname'   => $_ENV['DB_NAME'] ?? 'phalcon_vokuro',
    ],
    'application' => [
        'baseUri'         => $_ENV['APP_BASE_URI'] ?? '/',
        'publicUrl'       => $_ENV['APP_PUBLIC_URL'] ?? 'https://vokuro.phalcon.ld',
        'cryptSalt'       => $_ENV['APP_CRYPT_SALT'] ?? '',
        'viewsDir'        => root_path('themes/vokuro/'),
        'cacheDir'        => root_path('var/cache/'),
        'sessionSavePath' => root_path('var/cache/session/'),
    ],
    'mail'        => [
        'fromName'  => $_ENV['MAIL_FROM_NAME'] ?? 'Vokuro Mailer',
        'fromEmail' => $_ENV['MAIL_FROM_EMAIL'] ?? 'vokuro@localhost',
        'smtp'      => [
            'server'   => $_ENV['MAIL_SMTP_SERVER'] ?? 'localhost',
            'port'     => $_ENV['MAIL_SMTP_PORT'] ?? 25,
            'security' => $_ENV['MAIL_SMTP_SECURITY'] ?? '',
            'username' => $_ENV['MAIL_SMTP_USERNAME'] ?? '',
            'password' => $_ENV['MAIL_SMTP_PASSWORD'] ?? '',
        ],
    ],
    'logger'      => [
        'path'     => root_path('var/logs/'),
        'format'   => '%date% [%type%] %message%',
        'date'     => 'D j H:i:s',
        'logLevel' => Enum::DEBUG,
        'filename' => 'application.log',
    ],
    // Set to false, to disable sending emails (for use in test environment)
    'useMail'     => true,
];
