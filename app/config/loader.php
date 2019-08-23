<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Phalcon\Loader;

$loader = new Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces([
    'Vokuro\Models'      => $config->application->modelsDir,
    'Vokuro\Controllers' => $config->application->controllersDir,
    'Vokuro\Forms'       => $config->application->formsDir,
    'Vokuro'             => $config->application->libraryDir
]);

$loader->register();

// Use composer autoloader to load vendor classes
require_once BASE_PATH . '/vendor/autoload.php';
