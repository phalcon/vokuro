<?php
$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->libraryDir,
        $config->application->extendDir,
        $config->application->toolsDir,
        $config->application->pluginsDir,
        $config->application->logDir,
    )
)->register(); /* /End Registering Directories */

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces(array(
    'Vokuro\Controllers' => $config->application->controllersDir,
    'Vokuro\Models' => $config->application->modelsDir,
    'Vokuro\Forms' => $config->application->formsDir,
    'Vokuro' => $config->application->libraryDir,
    'Extend' => $config->application->extendDir,
    'Vokuro\Tools' => $config->application->toolsDir,
    'Vokuro\Plugins' => $config->application->pluginsDir,
));

$loader->register();

// Use composer autoloader to load vendor classes
require_once __DIR__ . '/../../vendor/autoload.php';
