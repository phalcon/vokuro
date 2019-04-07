<?php
/*
* Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
* NOTE: please remove this comment.
*/
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

use Phalcon\Logger;

return new \Phalcon\Config([
  'database' => [
    'adapter'     => 'Mysql',
    'host'        => 'localhost',
    'username'    => '',
    'password'    => '',
    'dbname'      => 'vokuro',
    'charset'     => 'utf8',
  ],
  'application' => [
    'appDir'         => APP_PATH . '/',
    'controllersDir' => APP_PATH . '/controllers/',
    'modelsDir'      => APP_PATH . '/models/',
    'formsDir'       => APP_PATH . '/forms/',
    'viewsDir'       => APP_PATH . '/views/',
    'libraryDir'     => APP_PATH . '/library/',
    'pluginsDir'     => APP_PATH . '/plugins/',
    'cacheDir'       => BASE_PATH . '/cache/',
    'logsDir'        => BASE_PATH . '/logs/',

    // This allows the baseUri to be understand project paths that are not in the root directory
    // of the webpspace.  This will break if the public/index.php entry point is moved or
    // possibly if the web server rewrite rules are changed. This can also be set to a static path.
    'baseUri'        => '/',
    'cryptSalt'      => 'eEAfR|_&G&f,+vU]:jFr!!A&+71w1Ms9~8_4L!<@[N@DyaIP_2My|:+.u>/6m,$D'
  ],
  'logger' => [
    'path'     => BASE_PATH . '/logs/',
    'format'   => '%date% [%type%] %message%',
    'date'     => 'D j H:i:s',
    'logLevel' => Logger::DEBUG,
    'filename' => 'application.log',
  ],
  // Set to false to disable sending emails (for use in test environment)
  'useMail' => false
]);
