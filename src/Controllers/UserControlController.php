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

namespace Vokuro\Controllers;

use Vokuro\Models\EmailConfirmations;
use Vokuro\Models\ResetPasswords;
use Vokuro\Models\Users;

/**
 * UserControlController
 * Provides help to users to confirm their passwords or reset them
 */
class UserControlController extends ControllerBase
{
    /**
     * Confirms an e-mail, if the user must change their password then changes
     * it
     */
    public function confirmEmailAction(): void
    {
        $code = $this->dispatcher->getParam('code');

        /** @var EmailConfirmations|false $confirmation */
        $confirmation = EmailConfirmations::findFirstByCode($code);
        if (!$confirmation instanceof EmailConfirmations) {
            $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);

            return;
        }

        if ($confirmation->confirmed != 'N') {
            $this->dispatcher->forward([
                'controller' => 'session',
                'action'     => 'login',
            ]);

            return;
        }

        /**
         * Activate user
         */
        $user = Users::findFirst($confirmation->user->id);
        $user->active = 'Y';
        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);

            return;
        }

        /**
         * Change the confirmation to 'confirmed' and update the user to 'active'
         */
        $confirmation->confirmed = 'Y';
        if (!$confirmation->save()) {
            foreach ($confirmation->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);

            return;
        }

        /**
         * Identify the user in the application
         */
        $this->auth->authUserById($confirmation->user->id);

        /**
         * Check if the user must change his/her password
         */
        if ($confirmation->user->mustChangePassword == 'Y') {
            $this->flashForward('success', 'The email was successfully confirmed. Now you must change your password', [
                'controller' => 'users',
                'action'     => 'changePassword',
            ]);

            return;
        }

        $this->flashForward('success', 'The email was successfully confirmed', [
            'controller' => 'users',
            'action'     => 'index',
        ]);
    }
    public function initialize(): void
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
    }

    public function resetPasswordAction(): void
    {
        $code = $this->dispatcher->getParam('code');

        /** @var ResetPasswords|false $resetPassword */
        $resetPassword = ResetPasswords::findFirstByCode($code);
        if (!$resetPassword instanceof ResetPasswords) {
            $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);

            return;
        }

        if ($resetPassword->reset != 'N') {
            $this->dispatcher->forward([
                'controller' => 'session',
                'action'     => 'login',
            ]);

            return;
        }

        $resetPassword->reset = 'Y';

        /**
         * Change the confirmation to 'reset'
         */
        if (!$resetPassword->save()) {
            foreach ($resetPassword->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);

            return;
        }

        /**
         * Identify the user in the application
         */
        $this->auth->authUserById($resetPassword->usersId);

        $this->flashForward('success', 'Please reset your password', [
            'controller' => 'users',
            'action'     => 'changePassword',
        ]);
    }
}
