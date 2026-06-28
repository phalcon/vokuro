<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vokuro\Tests\Functional;

use Phalcon\Talon\PHPUnit\AbstractFunctionalTestCase as TalonFunctionalTestCase;
use Vokuro\Application;

abstract class AbstractFunctionalTestCase extends TalonFunctionalTestCase
{
    protected function appFactory(): callable
    {
        return function () {
            $bootstrap = new Application(dirname(__DIR__, 2));

            return $this->getProtectedProperty($bootstrap, 'app');
        };
    }
}
