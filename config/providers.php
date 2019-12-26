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

use Vokuro\Providers\AclProvider;
use Vokuro\Providers\AuthProvider;
use Vokuro\Providers\ConfigProvider;
use Vokuro\Providers\CryptProvider;
use Vokuro\Providers\DbProvider;
use Vokuro\Providers\DispatcherProvider;
use Vokuro\Providers\FlashProvider;
use Vokuro\Providers\LoggerProvider;
use Vokuro\Providers\MailProvider;
use Vokuro\Providers\ModelsMetadataProvider;
use Vokuro\Providers\RouterProvider;
use Vokuro\Providers\SecurityProvider;
use Vokuro\Providers\SessionBagProvider;
use Vokuro\Providers\SessionProvider;
use Vokuro\Providers\UrlProvider;
use Vokuro\Providers\ViewProvider;
use Vokuro\Providers\AssetsProvider;

return [
    AclProvider::class,
    AuthProvider::class,
    ConfigProvider::class,
    CryptProvider::class,
    DbProvider::class,
    DispatcherProvider::class,
    FlashProvider::class,
    LoggerProvider::class,
    MailProvider::class,
    ModelsMetadataProvider::class,
    RouterProvider::class,
    SessionBagProvider::class,
    SessionProvider::class,
    SecurityProvider::class,
    UrlProvider::class,
    ViewProvider::class,
    AssetsProvider::class,
];
