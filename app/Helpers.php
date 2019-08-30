<?php
declare(strict_types=1);

namespace Vokuro;

use Phalcon\Di;
use Phalcon\Di\DiInterface;

/**
 * Call Dependency Injection container
 *
 * @param  mixed
 * @return DiInterface
 */
function container(): DiInterface
{
    $default = Di::getDefault();
    $args = func_get_args();
    if (empty($args)) {
        return $default;
    }

    return call_user_func_array([$default, 'get'], $args);
}

/**
 * Get configuration value
 *
 * Also can access nested values.
 * Example: config('config.db.name')
 *
 * @param mixed
 * @return mixed
 */
function config()
{
    $args = func_get_args();
    $config = Di::getDefault()->getShared('config');

    if (empty($args)) {
        return $config;
    }

    return call_user_func_array([$config, 'path'], $args);
}
