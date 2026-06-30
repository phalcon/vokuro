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

use Phalcon\Di\Di;
use Phalcon\Di\Injectable;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Application;
use Vokuro\Plugins\Acl\Acl;
use Vokuro\Tests\Support\DatabaseSeedTrait;

use function dirname;
use function unlink;

final class AclTest extends AbstractUnitTestCase
{
    use DatabaseSeedTrait;

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

    public function testAddPrivateResourcesRebuildsAnAlreadyBuiltAcl(): void
    {
        $this->reseedDatabase();

        $acl = $this->bootAcl();
        $acl->getAcl();

        $acl->addPrivateResources(['reports' => ['index']]);

        $this->assertArrayHasKey('reports', $acl->getResources());
    }

    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(Acl::class);

        $this->assertInstanceOf(Injectable::class, $class);
    }

    public function testGetAclRebuildsWhenTheCacheFileIsMissing(): void
    {
        $this->reseedDatabase();
        @unlink(dirname(__DIR__, 3) . '/var/cache/acl/data.txt');

        $acl = $this->bootAcl();

        $this->assertTrue($acl->getAcl()->isAllowed('Administrators', 'users', 'index'));
    }

    public function testGetActionDescriptionFallsBackToTheActionName(): void
    {
        $acl = $this->mockWithoutConstructor(Acl::class);

        $this->assertSame('Access', $acl->getActionDescription('index'));
        $this->assertSame('frobnicate', $acl->getActionDescription('frobnicate'));
    }

    private function bootAcl(): Acl
    {
        new Application(dirname(__DIR__, 3));

        return Di::getDefault()->getShared('acl');
    }
}
