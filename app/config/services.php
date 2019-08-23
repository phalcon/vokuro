<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Phalcon\Mvc\View;
use Phalcon\Crypt;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Stream as MetaDataAdapter;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Logger\Adapter\Stream as FileLogger;
use Phalcon\Logger\Formatter\Line as FormatterLine;
use Vokuro\Auth\Auth;
use Vokuro\Acl\Acl;
use Vokuro\Mail\Mail;
use Phalcon\Session\Manager as SessionManager;
use Phalcon\Session\Bag as SessionBag;

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
                'separator' => '_'
            ]);

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
    return new DbAdapter([
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
$di->set('session', function () {
    $config = $this->getConfig();

    $files = new SessionAdapter([
        'savePath' => $config->application->sessionSavePath,
    ]);
    $session = new SessionManager();
    $session->setHandler($files);
    $session->start();

    return $session;
});

/**
 * A component that helps separating session data into namespaces
 *
 * @see https://docs.phalconphp.com/4.0/en/session#session-bags
 */
$di->set('sessionBag', function () {
    return new SessionBag('conditions');
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
    return require APP_PATH . '/config/routes.php';
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

/**
 * Custom authentication component
 */
$di->set('auth', function () {
    return new Auth();
});

/**
 * Mail service uses AmazonSES
 */
$di->set('mail', function () {
    return new Mail();
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
 * Logger service
 */
$di->set('logger', function ($filename = null, $format = null) {
    $config = $this->getConfig();

    $format = $format ?: $config->get('logger')->format;
    $filename = trim($filename ?: $config->get('logger')->filename, '\\/');
    $path = rtrim($config->get('logger')->path, '\\/') . DIRECTORY_SEPARATOR;

    $formatter = new FormatterLine($format, $config->get('logger')->date);
    $logger = new FileLogger($path . $filename);

    $logger->setFormatter($formatter);
    $logger->setLogLevel($config->get('logger')->logLevel);

    return $logger;
});
