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

final class UsersControllerTest extends AbstractBrowserTestCase
{
    public function testChangePassword(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/changePassword');
        $this->assertPageContainsText('Change Password');
    }

    public function testChangePasswordShowsValidationErrors(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/changePassword');
        $this->fillField('password', 'short');
        $this->fillField('confirmPassword', 'different');
        $this->pressButton('Change Password');

        $this->assertPageContainsText('Password is too short. Minimum 8 characters');
    }

    public function testChangePasswordUpdatesPassword(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/changePassword');
        $this->fillField('password', 'new-password1');
        $this->fillField('confirmPassword', 'new-password1');
        $this->pressButton('Change Password');

        $this->assertPageContainsText('Your password was successfully changed');
    }

    public function testCreate(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/create');
        $this->assertPageContainsText('Create a User');
    }

    public function testCreatePersistsUser(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/create');
        $this->fillField('name', 'Janelle Voight');
        $this->fillField('email', 'janelle.voight@resistance.dev');
        $this->selectOption('profilesId', '2');
        $this->pressButton('Save');

        $this->assertPageContainsText('User was created successfully');
    }

    public function testCreateShowsFormValidationErrors(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/create');
        $this->fillField('name', '');
        $this->fillField('email', 'not-an-email');
        $this->selectOption('profilesId', '1');
        $this->pressButton('Save');

        $this->assertPageContainsText('The e-mail is not valid');
    }

    public function testCreateShowsValidationErrors(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/create');
        $this->fillField('name', 'Sarah Clone');
        $this->fillField('email', 'sarah.connor@skynet.dev');
        $this->selectOption('profilesId', '1');
        $this->pressButton('Save');

        $this->assertPageContainsText('The email is already registered');
    }

    public function testDelete(): void
    {
        $this->loginAsAdmin();

        // Tarissa Dyson (id 4) is seeded with no activity, so she can be deleted.
        // The per-test reseed restores her for the next test.
        $this->visitPage('/users/delete/4');

        $this->visitPage('/users/search');
        $this->assertPageMissingText('Tarissa Dyson');
    }

    public function testDeleteNotFound(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/delete/999');
        $this->assertPageContainsText('User was not found.');
    }

    public function testDeleteWithActivityIsBlocked(): void
    {
        $this->loginAsAdmin();

        // Sarah (id 1) just logged in, so she has a successful-login record and
        // cannot be deleted (the related-records foreign key blocks it).
        $this->visitPage('/users/delete/1');
        $this->assertPageContainsText('User cannot be deleted because he/she has activity in the system');
    }

    public function testEdit(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/edit/1');
        $this->assertPageContainsText('Edit users');
    }

    public function testEditNotFound(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/edit/999');
        $this->assertPageContainsText('User was not found.');
    }

    public function testEditShowsValidationErrors(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/edit/1');
        $this->fillField('email', 'not-an-email');
        $this->pressButton('Save');

        $this->assertPageContainsText('The e-mail is not valid');
    }

    public function testEditUpdatesUser(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/edit/1');
        $this->fillField('name', 'Sarah J. Connor');
        $this->pressButton('Save');

        $this->assertPageContainsText('User was updated successfully.');
    }

    public function testEditWithDuplicateEmailIsRejected(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/edit/1');
        $this->fillField('email', 'john.connor@skynet.dev');
        $this->pressButton('Save');

        $this->assertPageContainsText('The email is already registered');
    }

    public function testIndex(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users');
        $this->assertPageContainsText('Search users');
    }

    public function testIndexAsGuest(): void
    {
        $this->visitPage('/users');

        $this->assertPageContainsText('You do not have access to this module: private');
    }

    public function testSearch(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/search');
        $this->assertPageContainsText('Found users');
    }

    public function testSearchWithNoResults(): void
    {
        $this->loginAsAdmin();

        $this->visitPage('/users/search?name=ZZZNoSuchUser');
        $this->assertPageContainsText('The search did not find any users');
    }
}
