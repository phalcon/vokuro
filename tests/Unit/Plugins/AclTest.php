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

use Phalcon\Acl\Adapter\Memory as AclMemory;
use Phalcon\Di\Di;
use Phalcon\Di\Injectable;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Application;
use Vokuro\Plugins\Acl\Acl;
use Vokuro\Tests\Support\DatabaseSeedTrait;
use Vokuro\Tests\Support\FakeApcuAcl;

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

    public function testGetAclReturnsTheApcuCachedValueWhenAvailable(): void
    {
        FakeApcuAcl::reset();
        $cached               = new AclMemory();
        FakeApcuAcl::$fetched = $cached;

        // APCu reports a hit, so getAcl() returns the cached ACL untouched.
        $this->assertSame($cached, $this->bootFakeApcuAcl()->getAcl());
    }

    public function testGetAclStoresARebuiltAclInApcuWhenTheCacheFileIsMissing(): void
    {
        $this->reseedDatabase();
        FakeApcuAcl::reset();
        @unlink(dirname(__DIR__, 3) . '/var/cache/acl/data.txt');

        // Cache miss + no file: getAcl() rebuilds and primes APCu.
        $this->bootFakeApcuAcl()->getAcl();

        $this->assertArrayHasKey('vokuro-acl', FakeApcuAcl::$stored);
    }

    public function testGetAclStoresTheCachedFileAclInApcuWhenAvailable(): void
    {
        $this->reseedDatabase();
        FakeApcuAcl::reset();

        $acl = $this->bootFakeApcuAcl();
        $acl->rebuild();
        FakeApcuAcl::$stored = [];

        // Cache miss but the file exists: getAcl() reads it and primes APCu.
        $acl->getAcl();

        $this->assertArrayHasKey('vokuro-acl', FakeApcuAcl::$stored);
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

    private function bootFakeApcuAcl(): FakeApcuAcl
    {
        new Application(dirname(__DIR__, 3));

        // Mirror the private resources the real 'acl' service is configured with
        // so rebuild() can grant permissions against known components.
        $acl = new FakeApcuAcl();
        $acl->addPrivateResources(Di::getDefault()->getShared('acl')->getResources());

        return $acl;
    }
}
