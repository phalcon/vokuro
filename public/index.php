<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application;

error_reporting(E_ALL);

require_once dirname(__DIR__) . '/bootstrap/autoload.php';

try {
    // Use composer autoloader to load vendor classes
    require_once BASE_PATH . '/vendor/autoload.php';

    /**
     * Load .env configurations
     */
    $dotenv = Dotenv\Dotenv::create(BASE_PATH);
    $dotenv->load();

    /**
     * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
     */
    $di = new FactoryDefault();

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Handle the request
     */
    $application = new Application($di);

    echo $application->handle($_SERVER['REQUEST_URI'])
        ->getContent();

} catch (Exception $e) {
    echo $e->getMessage(), '<br>';
    echo nl2br(htmlentities($e->getTraceAsString()));
}
