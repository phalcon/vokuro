<?php
declare(strict_types=1);

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
    public function initialize(): void
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
    }

    /**
     * Confirms an e-mail, if the user must change their password then changes
     * it
     */
    public function confirmEmailAction()
    {
        $code = $this->dispatcher->getParam('code');

        /** @var EmailConfirmations|false $confirmation */
        $confirmation = EmailConfirmations::findFirstByCode($code);
        if (!$confirmation instanceof EmailConfirmations) {
            return $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);
        }

        if ($confirmation->confirmed != 'N') {
            return $this->dispatcher->forward([
                'controller' => 'session',
                'action'     => 'login',
            ]);
        }

        /**
         * Activate user
         */
        $user = Users::findFirst($confirmation->user->id);
        $user->active = 'Y';
        if (!$user->save()) {
            foreach ($confirmation->user->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            return $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);
        }

        /**
         * Change the confirmation to 'confirmed' and update the user to 'active'
         */
        $confirmation->confirmed = 'Y';
        if (!$confirmation->save()) {
            foreach ($confirmation->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            return $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);
        }

        /**
         * Identify the user in the application
         */
        $this->auth->authUserById($confirmation->user->id);

        /**
         * Check if the user must change his/her password
         */
        if ($confirmation->user->mustChangePassword == 'Y') {
            $this->flash->success('The email was successfully confirmed. Now you must change your password');

            return $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'changePassword',
            ]);
        }

        $this->flash->success('The email was successfully confirmed');

        return $this->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'index',
        ]);
    }

    public function resetPasswordAction()
    {
        $code = $this->dispatcher->getParam('code');

        /** @var ResetPasswords|false $resetPassword */
        $resetPassword = ResetPasswords::findFirstByCode($code);
        if (!$resetPassword instanceof ResetPasswords) {
            return $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);
        }

        if ($resetPassword->reset != 'N') {
            return $this->dispatcher->forward([
                'controller' => 'session',
                'action'     => 'login',
            ]);
        }

        $resetPassword->reset = 'Y';

        /**
         * Change the confirmation to 'reset'
         */
        if (!$resetPassword->save()) {
            foreach ($resetPassword->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            return $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);
        }

        /**
         * Identify the user in the application
         */
        $this->auth->authUserById($resetPassword->usersId);

        $this->flash->success('Please reset your password');

        return $this->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'changePassword',
        ]);
    }
}
