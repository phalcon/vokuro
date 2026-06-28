<?php

declare(strict_types=1);

namespace Vokuro;

use Phalcon\Di\Di;
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
 * Read an environment variable, falling back from getenv() to $_ENV.
 *
 * Dotenv variants populate getenv() and/or $_ENV depending on which adapter is
 * used, so both are checked: real OS/CI variables win, with the loaded .env file
 * as the fallback (mirrors the helper used in phalcon/cphalcon's test suite).
 *
 * @param string $key
 * @param mixed  $default
 *
 * @return mixed
 */
function env(string $key, mixed $default = null): mixed
{
    $value = getenv($key);
    if (false !== $value) {
        return $value;
    }

    return $_ENV[$key] ?? $default;
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
