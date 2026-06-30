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

final class PermissionsControllerTest extends AbstractBrowserTestCase
{
    public function testIndexAsAdmin(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/permissions');
        $this->assertPageContainsText('Manage Permissions');
    }

    public function testIndexAsGuest(): void
    {
        $this->visitPage('/permissions');

        $this->assertPageContainsText('You do not have access to this module: private');
    }

    public function testIndexUpdatesPermissions(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/permissions');

        // Select the Administrators profile and load its permission grid.
        $this->selectOption('profileId', '1');
        $this->pressButton('Search');

        // The profile's current permissions are pre-checked; resubmitting them
        // exercises the delete-and-resave path and flashes the confirmation.
        $this->pressButton('Submit');
        $this->assertPageContainsText('Permissions were updated with success');
    }

    public function testIndexWithoutProfileSelected(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/permissions');

        // Submitting with the empty placeholder posts a profileId that matches no
        // profile, exercising the "profile not found" path.
        $this->pressButton('Search');
        $this->assertPageContainsText('Manage Permissions');
    }
}
