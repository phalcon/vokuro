<?php

error_reporting(E_ALL ^ E_NOTICE);

// Set internal character encoding to UTF-8.
//mb_internal_encoding('UTF-8');
ini_set('memory_limit', '-1');

define('APP_PATH', realpath('..') . '/');
/**
 * Define some useful constants
 */
define('PS', PATH_SEPARATOR);
define('DS', DIRECTORY_SEPARATOR);
define('PUBLIC_DIR', __DIR__ . DS);
define('ROOT_DIR', dirname(__DIR__) . DS);
define('BASE_DIR', str_replace('\\', '/', dirname(__DIR__)));
define('APP_DIR', BASE_DIR . '/app');
define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'local'));


try {

    /**
     * Read the configuration
     */
    $config = include APP_DIR . '/config/config.php';

    /**
     * Auto-loader configuration
     */
  require APP_DIR . DS . 'config/loader.php';

    /**
     * Load application services
     */
    include APP_DIR . '/config/services.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (Phalcon\Exception $e) {
    echo $e->getMessage(), '<br>';
  echo nl2br(htmlentities($e->getTraceAsString()));
} catch (PDOException $e) {
    echo $e->getMessage(), '<br>';
echo nl2br(htmlentities($e->getTraceAsString()));
}
