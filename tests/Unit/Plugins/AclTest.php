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

namespace Vokuro\Tests\Unit\Plugins;

use Phalcon\Di\Injectable;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Plugins\Acl\Acl;

final class AclTest extends AbstractUnitTestCase
{
    public function testAddPrivateResourcesIgnoresAnEmptyList(): void
    {
        $acl = $this->mockWithoutConstructor(Acl::class);

        $acl->addPrivateResources([]);

        $this->assertSame([], $acl->getResources());
    }

    public function testAddPrivateResourcesMergesResources(): void
    {
        $acl = $this->mockWithoutConstructor(Acl::class);

        $acl->addPrivateResources(['users' => ['index', 'search']]);

        $this->assertSame(['users' => ['index', 'search']], $acl->getResources());
    }

    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(Acl::class);

        $this->assertInstanceOf(Injectable::class, $class);
    }

    public function testGetActionDescriptionFallsBackToTheActionName(): void
    {
        $acl = $this->mockWithoutConstructor(Acl::class);

        $this->assertSame('Access', $acl->getActionDescription('index'));
        $this->assertSame('frobnicate', $acl->getActionDescription('frobnicate'));
    }
}
