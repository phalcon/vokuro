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

namespace Vokuro\Tests\Unit\Providers;

use Phalcon\Config\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Encryption\Crypt;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Providers\CryptProvider;

final class CryptProviderTest extends AbstractUnitTestCase
{
    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(CryptProvider::class);

        $this->assertInstanceOf(ServiceProviderInterface::class, $class);
    }

    public function testRegistersCryptService(): void
    {
        $di = new FactoryDefault();
        $di->setShared('config', new Config([
            'application' => [
                'cryptSalt' => '12345678901234567890123456789012',
            ],
        ]));

        (new CryptProvider())->register($di);

        $this->assertInstanceOf(Crypt::class, $di->get('crypt'));
    }
}
