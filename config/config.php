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

use Phalcon\Logger\Enum as Logger;

use function Vokuro\env;
use function Vokuro\root_path;

return [
    'database'    => [
        'adapter'  => env('DB_ADAPTER'),
        'host'     => env('DB_HOST'),
        'port'     => env('DB_PORT'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'dbname'   => env('DB_NAME'),
    ],
    'application' => [
        'baseUri'         => env('APP_BASE_URI'),
        'publicUrl'       => env('APP_PUBLIC_URL'),
        'cryptSalt'       => env('APP_CRYPT_SALT'),
        'viewsDir'        => root_path('themes/vokuro/'),
        'cacheDir'        => root_path('var/cache/'),
        'sessionSavePath' => root_path('var/cache/session/'),
    ],
    'mail'        => [
        'fromName'  => env('MAIL_FROM_NAME'),
        'fromEmail' => env('MAIL_FROM_EMAIL'),
        'smtp'      => [
            'server'   => env('MAIL_SMTP_SERVER'),
            'port'     => env('MAIL_SMTP_PORT'),
            'security' => env('MAIL_SMTP_SECURITY'),
            'username' => env('MAIL_SMTP_USERNAME'),
            'password' => env('MAIL_SMTP_PASSWORD'),
        ],
    ],
    'logger'      => [
        'path'     => root_path('var/logs/'),
        'format'   => '%date% [%type%] %message%',
        'date'     => 'D j H:i:s',
        'logLevel' => Logger::DEBUG,
        'filename' => 'application.log',
    ],
    // Set to false to disable sending emails (for use in test environment)
    'useMail'     => true,
];
