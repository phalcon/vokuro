<?php

declare(strict_types=1);

require_once dirname(__FILE__, 2) . "/vendor/autoload.php";

use Phalcon\Talon\Settings;
use Phalcon\Talon\Talon;

Talon::boot(Settings::fromEnv());
