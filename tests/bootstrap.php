<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Phalcon\Talon\Settings;
use Phalcon\Talon\Talon;

require_once dirname(__FILE__, 2) . "/vendor/autoload.php";
require_once __DIR__ . '/Support/sleep_override.php';

/**
 * Load the test environment into $_ENV. Real OS/CI variables (read first by
 * Vokuro\env()) win, so the same suite runs both in docker (service-name hosts
 * from the container environment) and in native CI (localhost from .env.test).
 */
Dotenv::createImmutable(__DIR__, '.env.test')->safeLoad();

Talon::boot(Settings::fromEnv());
