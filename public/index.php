<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Phalcon\Debug;
use Vokuro\Application as VokuroApplication;

error_reporting(E_ALL);
$rootPath = dirname(__DIR__);

require_once $rootPath . '/vendor/autoload.php';

/**
 * Register the Phalcon\Debug exception renderer. With no surrounding try/catch,
 * uncaught exceptions unwind to set_exception_handler() and are shown as the
 * debug page.
 *
 * BE VERY CAREFUL - the debug page exposes sensitive information (backtrace,
 * request/server globals, source fragments).
 *
 * !!! DO NOT USE IN PRODUCTION !!!
 */
(new Debug())->listen();

/**
 * Load .env configurations
 */
Dotenv\Dotenv::createUnsafeImmutable($rootPath)->safeLoad();

/**
 * Run Vökuró!
 */
echo (new VokuroApplication($rootPath))->run();
