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

use Phalcon\Logger\Logger;

return [
    'database' => [
        'adapter' => getenv('DB_ADAPTER'),
        'host' => getenv('DB_HOST'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'dbname' => getenv('DB_NAME'),
    ],
    'application' => [
        'baseUri' => getenv('APP_BASE_URI'),
        'publicUrl' => getenv('APP_PUBLIC_URL'),
        'cryptSalt' => getenv('APP_CRYPT_SALT'),
        'sessionSavePath' => BASE_PATH . '/cache/session/',
        'viewsDir' => APP_PATH . '/views/',
        'cacheDir' => BASE_PATH . '/cache/',
    ],
    'mail' => [
        'fromName' => getenv('MAIL_FROM_NAME'),
        'fromEmail' => getenv('MAIL_FROM_EMAIL'),
        'smtp' => [
            'server' => getenv('MAIL_SMTP_SERVER'),
            'port' => getenv('MAIL_SMTP_PORT'),
            'security' => getenv('MAIL_SMTP_SECURITY'),
            'username' => getenv('MAIL_SMTP_USERNAME'),
            'password' => getenv('MAIL_SMTP_PASSWORD'),
        ]
    ],
    'amazon' => [
        'AWSAccessKeyId' => '',
        'AWSSecretKey' => '',
    ],
    'logger' => [
        'path' => BASE_PATH . '/logs/',
        'format' => '%date% [%type%] %message%',
        'date' => 'D j H:i:s',
        'logLevel' => Logger::DEBUG,
        'filename' => 'application.log',
    ],
    // Set to false to disable sending emails (for use in test environment)
    'useMail' => true,
];
