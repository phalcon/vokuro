<?php

error_reporting(E_ALL ^ E_NOTICE);

//(new \Phalcon\Debug())->listen();

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
define('ROOT_DIR', str_replace('\\', '/', dirname(__DIR__) . DS));
define('APP_DIR', ROOT_DIR . 'app');
/*  Stages are : staging, development, production   */
define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

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
    include_once APP_DIR . '/config/services.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    // register modules
    include APP_DIR . '/config/modules.php';

    echo $application->handle()->getContent();

} catch (PDOException $e) {

    echo "<!DOCTYPE html>\n<html>\n<head>\n";
    echo "<link href='/css/bootstrap.min.css' media='screen' rel='stylesheet' type='text/css' />\n";
    echo "</head>\n";
    echo "<body>\n";
    echo "<div class='jumbotron'>\n";
    echo "<h2>PhalconPDO Exception" . $e->getMessage() . "</h2><br />";
    echo "<strong>TraceAsString:</strong><br />\n";
    echo nl2br(htmlentities($e->getTraceAsString()));
    echo "
    </div>\n\n";
    echo "</body>\n</html>";
    exit;

} catch (\Exception $e) {

    if (preg_match("/Module (.*) isn't registered/ius", $e->getMessage()) == 1) {
        // caught module is not registered error!
        // @todo [phalconbegins][multi modules] find the way to use error controller.
        header('HTTP/1.0 404 Not Found');
        echo "<!DOCTYPE html>\n<html>\n<head>\n";
        echo "<link href='/css/bootstrap.min.css' media='screen' rel='stylesheet' type='text/css' />\n";
        echo "</head>\n";
        echo "<body>\n";
        echo "<div class='jumbotron'>\n";
        // another error!
        echo "<h1>Hellloooow Custom error handler please</h1>";
        echo "<h2>" . get_class($e), ": ", $e->getMessage(), "</h2><br />\n";
        //echo " File=", $e->getFile(), "<br />\n";
        //echo " Line=", $e->getLine(), "<br />\n";
        echo "<strong>TraceAsString:</strong><br />\n";
        echo nl2br(htmlentities($e->getTraceAsString()));
        echo "
    </div>\n\n";
        echo "</body>\n</html>";
        exit;
    } else {
        echo "<!DOCTYPE html>\n<html>\n<head>\n";
        echo "<link href='/css/bootstrap.min.css' media='screen' rel='stylesheet' type='text/css' />\n";
        echo "</head>\n";
        echo "<body>\n";
        echo "<div class='jumbotron'>\n";
        echo "<h1>Hellloooow Custom error handler please</h1>";
        echo $e->getMessage(), '<br>';
        echo nl2br(htmlentities($e->getTraceAsString()));
        echo "
    </div>\n\n";
        echo "</body>\n</html>";
    }
}
