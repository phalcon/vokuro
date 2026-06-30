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

final class ProfilesControllerTest extends AbstractBrowserTestCase
{
    public function testCreate(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/profiles/create');
        $this->assertPageContainsText('Create a Profile');
    }

    public function testDelete(): void
    {
        $this->loginAsAdmin();

        // Provision a throwaway profile (no users assigned, so it can be deleted),
        // then remove it. The per-test reseed leaves the seeded profiles untouched.
        $this->visitPage('/profiles/create');
        $this->fillField('name', 'T-800');
        $this->selectOption('active', 'Y');
        $this->pressButton('Save');
        $this->assertPageContainsText('Profile was created successfully');

        $this->visitPage('/profiles');
        $this->assertPageContainsText('T-800');

        $this->clickLink('Delete', '//tr[td[contains(., "T-800")]]');
        $this->assertPageMissingText('T-800');
    }

    public function testDeleteBlockedWhenProfileHasUsers(): void
    {
        $this->loginAsAdmin();

        // The Administrators profile (id 1) is assigned to users, so it cannot be deleted.
        $this->visitPage('/profiles/delete/1');
        $this->assertPageContainsText('Profile cannot be deleted because it\'s used on Users');
    }

    public function testDeleteNotFound(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/profiles/delete/999');
        $this->assertPageContainsText('Profile was not found');
    }

    public function testEdit(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/profiles/edit/1');
        $this->assertPageContainsText('Edit profile');
    }

    public function testEditNotFound(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/profiles/edit/999');
        $this->assertPageContainsText('Profile was not found');
    }

    public function testEditUpdatesProfile(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/profiles/edit/1');
        $this->fillField('name', 'Administrators Updated');
        $this->selectOption('active', 'Y');
        $this->pressButton('Save');

        $this->assertPageContainsText('Profile was updated successfully');
    }

    public function testIndex(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/profiles');
        $this->assertPageContainsText('Search profiles');
    }

    public function testIndexAsGuest(): void
    {
        $this->visitPage('/profiles');

        $this->assertPageContainsText('You do not have access to this module: private');
    }

    public function testSearch(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/profiles');
        $this->pressButton('Search');
        $this->assertPageContainsText('Found profiles');
    }

    public function testSearchWithNoResults(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/profiles');
        $this->fillField('name', 'ZZZNoSuchProfile');
        $this->pressButton('Search');
        $this->assertPageContainsText('The search did not find any profiles');
    }
}
