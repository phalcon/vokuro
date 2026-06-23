<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Vokuro\Application as VokuroApplication;

error_reporting(E_ALL);
$rootPath = dirname(__DIR__);

try {
    require_once $rootPath . '/vendor/autoload.php';

    /**
     * Load .env configurations
     */
    Dotenv\Dotenv::createImmutable($rootPath)->safeLoad();

    /**
     * Run Vökuró!
     */
    echo (new VokuroApplication($rootPath))->run();
} catch (Exception $e) {
    /**
     * BE VERY CAREFUL WITH THIS CODE - IT IS A SAMPLE NOT PRODUCTION CODE
     *
     * Exceptions can carry sensitive information such as database credentials.
     *
     * !!! DO NOT USE THE CODE BELOW IN PRODUCTION !!!
     */
    echo $e->getMessage(), '<br>';
    echo nl2br(htmlentities($e->getTraceAsString()));
}
