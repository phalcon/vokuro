<?php
use Phalcon\Mvc\View;
use Phalcon\Crypt;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Files as MetaDataAdapter;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Files;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Flash\Session as FlashSession;
use Vokuro\Auth\Auth;
use Vokuro\Acl\Acl;
use Vokuro\Avatar\Gravatar;

/**
 * Register the global configuration as config
*/
$di->setShared('config', function () {
    $config = include APP_PATH . '/config/config.php';
    if (is_readable(APP_PATH . '/config/config.dev.php')) {
        $override = include APP_PATH . '/config/config.dev.php';
        $config->merge($override);
    }
    return $config;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

/**
 * Setting up the view component
 */
$di->set('view', function () {
    $config = $this->getConfig();

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();
            $volt = new VoltEngine($view, $this);
            $volt->setOptions([
                'path' => $config->application->cacheDir . 'volt/',
            ]);
            $compiler = $volt->getCompiler();
            $compiler->addFunction('strtotime', 'strtotime');
            $compiler->addFunction('number_format', 'number_format');

            return $volt;
        }
    ]);

    return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () {
    $config = $this->getConfig();
    return new Connection([
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname
    ]);
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    $config = $this->getConfig();
    return new MetaDataAdapter([
        'metaDataDir' => $config->application->cacheDir . 'metaData/'
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new Manager();
    $session->setHandler(new Files());
    $session->start();
    return $session;
});


/**
 * Crypt service
 */
$di->set('crypt', function () {
    $config = $this->getConfig();

    $crypt = new Crypt();
    $crypt->setKey($config->application->cryptSalt);
    return $crypt;
});

/**
 * Dispatcher use a default namespace
 */
$di->set('dispatcher', function () {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Vokuro\Controllers');
    return $dispatcher;
});

/**
 * Loading routes from the routes.php file
 */
$di->set('router', function () {
    return require APP_PATH . '/config/router.php';
});

/**
 * Flash service with custom CSS classes
 */
$di->set('flash', function () {
    return new Flash([
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

// Set up the flash session service
$di->set(
    'flashSession',
    function () {
        return new FlashSession([
            'error' => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice' => 'alert alert-info',
            'warning' => 'alert alert-warning'
        ]);
    }
);

/**
 * Custom authentication component
 */
$di->set('auth', function () {
    return new Auth();
});


/**
 * Setup the private resources, if any, for performance optimization of the ACL.
 */
$di->setShared('AclResources', function () {
    $pr = [];
    if (is_readable(APP_PATH . '/config/privateResources.php')) {
        $pr = include APP_PATH . '/config/privateResources.php';
    }
    return $pr;
});

/**
 * Access Control List
 * Reads privateResource as an array from the config object.
 */
$di->set('acl', function () {
    $acl = new Acl();
    $pr = $this->getShared('AclResources')->privateResources->toArray();
    $acl->addPrivateResources($pr);
    return $acl;
});


/**
 * Gravatar
 * Add user avatar for user panel
 */
$di->setShared('gravatar', function () {
    // Get Gravatar instance
    $gravatar = new Gravatar([]);
    // Setting default image, maximum size and maximum allowed Gravatar rating
    $gravatar->enableSecureURL();
    $gravatar->setDefaultImage('retro')->setSize(100)->setRating(Gravatar::RATING_PG);
    return $gravatar;
});
