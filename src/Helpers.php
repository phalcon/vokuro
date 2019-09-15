<?php
declare(strict_types=1);

namespace Vokuro;

use Phalcon\Di;
use Phalcon\Di\DiInterface;

/**
 * Call Dependency Injection container
 *
 * @return mixed|null|DiInterface
 */
function container()
{
    $default = Di::getDefault();
    $args    = func_get_args();
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
 * @return mixed
 */
function config()
{
    $args   = func_get_args();
    $config = Di::getDefault()->getShared('config');

    if (empty($args)) {
        return $config;
    }

    return call_user_func_array([$config, 'path'], $args);
}

/**
 * Get projects relative root path
 *
 * @param string $prefix
 *
 * @return string
 */
function root_path(string $prefix = ''): string
{
    /** @var Application $application */
    $application = container(Application::APPLICATION_PROVIDER);

    return join(DIRECTORY_SEPARATOR, [$application->getRootPath(), ltrim($prefix, DIRECTORY_SEPARATOR)]);
}
