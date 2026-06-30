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

namespace Vokuro\Tests\Browser\Controllers;

use Vokuro\Tests\Browser\AbstractBrowserTestCase;

/**
 * Tarissa Dyson is in the "Users" profile, which may access the users index but
 * not its delete action and not the permissions module at all. Those two cases
 * drive both fall-back branches of ControllerBase::beforeExecuteRoute.
 */
final class AccessControlTest extends AbstractBrowserTestCase
{
    public function testForbiddenActionFallsBackToControllerIndex(): void
    {
        $this->loginAs('tarissa.dyson@cyberdyne.dev', 'password4');

        $this->visitPage('/users/delete/1');
        $this->assertPageContainsText('You do not have access to this module: users:delete');
        $this->assertPageContainsText('Search users');
    }

    public function testForbiddenModuleFallsBackToHome(): void
    {
        $this->loginAs('tarissa.dyson@cyberdyne.dev', 'password4');

        $this->visitPage('/permissions');
        $this->assertPageContainsText('You do not have access to this module: permissions:index');
        $this->assertPageContainsText('Welcome!');
    }
}
