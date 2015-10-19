<?php
use Phalcon\DI\FactoryDefault;
use Phalcon\DI;
use Phalcon\Mvc\View;
use Phalcon\Crypt;
use Phalcon\Security;
use Phalcon\Mvc\Router;
use Phalcon\Flash\Session;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Response\Cookies;
use Phalcon\Mvc\Collection\Manager;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Cache\Backend\Memcache;
use Phalcon\Mvc\Url as UrlResolver;

use Phalcon\Translate\Adapter\Gettext;
use Phalcon\Cache\Backend\Libmemcached;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Files as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Flash\Direct as Flash;

use Vokuro\Plugins\Security as SecurityPlugin;
use Vokuro\Plugins\NotFound as NotFoundPlugin;

use Vokuro\Auth\Auth;
use Vokuro\Acl\Acl;
use Vokuro\Mail\Mail;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * Registers the configuration itself as a service
 */
$config = include ROOT_DIR . '/app/config/config.php';

if (file_exists(ROOT_DIR . 'app/config/config.' . APPLICATION_ENV . '.php')) {
    $overrideConfig = include ROOT_DIR . 'app/config/config.' . APPLICATION_ENV . '.php';
    $config->merge($overrideConfig);
}

/*
 **/
$di->set('config', $config, true);

/*
 * setup timezone
 **/
date_default_timezone_set($di->get('config')->application->timezone ?: 'UTC');

/**
 * Loading routes from the routes.php file
 */
$di->set(
    'router',
    function () {
    return require __DIR__ . '/routes.php';
}, true);


/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set(
    'url',
    function () use ($di) {
        $url = new UrlResolver();
        $config = $di->get('config');
        $url->setBaseUri($config->application->baseUri);
        if (!$config->application->debug) {
            $url->setStaticBaseUri($config->application->production->staticBaseUri);
        } else {
            $url->setStaticBaseUri($config->application->development->staticBaseUri);
        }
        return $url;
    }
);

/**
 * Start the session the first time some component request the session service
 */
$di->set(
    'session',
    function () {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});


/**
 * This service controls the initialization of models, keeping record of relations
 * between the different models of the application.
 */
$di->set(
    'collectionManager',
    function () {
        return new Manager();
    }
);

/*
 **/
$di->set(
    'modelsManager',
    function () {
        return new ModelsManager();
    }
);


/*
 *  Set the views cache service
 **/
$di->set(
    'viewCache',
    function () use ($di) {
        $config = $di->get('config');
        if ($config->application->debug) {
            $frontCache = new FrontendNone();
            return new MemoryBackend($frontCache);
        } else {
            //Cache data for one day by default
            $frontCache = new FrontendOutput(
                array(
                    "lifetime" => $config->cache->lifetime
                )
            );
            return new FileCache(
                $frontCache,
                array(
                    "cacheDir" => $config->cache->cacheDir,
                    "prefix" => $config->cache->prefix
                )
            );
        }
    }
);


/**
 * Setting up the view component
 */
$di->set(
    'view',
    function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir . 'volt/',
                'compiledSeparator' => '_'
            ));

            return $volt;
        }
    ));

    return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set(
    'db',
    function () use ($di) {
        //  @todo use $di->get('config')->database->adapter
        return new DbAdapter([
            'host' => $di->get('config')->database->host,
            'username' => $di->get('config')->database->username,
            'password' => $di->get('config')->database->password,
            'dbname' => $di->get('config')->database->dbname,
            'options' => array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $di->get('config')->database->charset
            )
        ]);
    }, true);

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set(
    'modelsMetadata',
    function () use ($config) {
    return new MetaDataAdapter(array(
        'metaDataDir' => $config->application->cacheDir . 'metaData/'
    ));
});

/*
 *  Cookies
 **/
$di->set(
    'cookies',
    function () {
        $cookies = new Cookies();
        $cookies->useEncryption(false);
        return $cookies;
    },
    true
);

/*
 *  Encryption for the passwords
 **/
$di->set(
    'crypt',
    function () use ($di) {
        $crypt = new Crypt();
        $crypt->setKey($di->get('config')->application->cryptSalt); //Use your own key!

        return $crypt;
    }
);

/*
 *  Security
 **/
$di->set(
    'security',
    function () {
        $security = new Security();
        //Set the password hashing factor to 12 rounds
        $security->setWorkFactor(12);
        return $security;
    },
    true
);

/*
 *  Set the models cache service
 **/
$di->set(
    'modelsCache',
    function () {

        //Cache data for one day by default
        $frontCache = new Data(
            array(
                "lifetime" => 86400
            )
        );

        //Memcached connection settings
        $cache = new Memcache(
            $frontCache,
            array(
                "host" => "localhost",
                "port" => "11211"
            )
        );

        return $cache;
    }
);


/**
 * Dispatcher use a default namespace
 */
$di->set(
    'dispatcher',
    function () use ($di) {
        $eventsManager = new EventsManager;
        $eventsManager->attach('dispatch:beforeDispatch', new SecurityPlugin);
        $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin);
        $dispatcher = new Dispatcher;
        $dispatcher->setDefaultNamespace('Vokuro\Controllers');
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);


/**
 * Flash service with custom CSS classes
 */
$di->set(
    'flash',
    function () {
    return new Flash(array(
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ));
});

/**
 * Custom authentication component
 */
$di->set(
    'auth',
    function () {
    return new Auth();
});

/**
 * Mail service uses AmazonSES
 */
$di->set(
    'mail',
    function () {
    return new Mail();
});

/**
 * Access Control List
 */
$di->set(
    'acl',
    function () {
    return new Acl();
});


/*
 *  Translation application use gettext
 **/
$di->set(
    'translation',
    function () use ($di) {
        $translation = new Gettext(
            [
                'locale' => $di->get('config')->language,
                'directory' => ROOT_DIR . '/apps/lang',
                'defaultDomain' => 'messages',

            ]
        );
        return $translation;
    },
    true
);

/**
 * Translation function call anywhere
 *
 * @param $string
 *
 * @return mixed
 */
function t($string)
{
    $translation = DI::getDefault()->get('translation');
    return $translation->_($string);
}

/*
 *  Phalcon Debugger
 **/
if ($config->application->debug) {
    (new \Phalcon\Debug)->listen();

    function dpm($object, $kill = true)
    {
        echo '<pre style="text-aling:left">';
        print_r($object);
        if ($kill) {
            die('END');
        }
        echo '</pre>';
    }
}
