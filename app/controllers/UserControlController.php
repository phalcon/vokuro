<?php

/*
  +------------------------------------------------------------------------+
  | Vökuró                                                                 |
  +------------------------------------------------------------------------+
  | Copyright (c) 2016-present Phalcon Team (https://www.phalconphp.com)   |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file LICENSE.txt.                             |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
*/

namespace Vokuro\Controllers;

use Vokuro\Models\ResetPasswords;
use Vokuro\Models\EmailConfirmations;

/**
 * UserControlController. Provides help to users to confirm their passwords or reset them
 * Vokuro\Controllers\UserControlController
 * @package Vokuro\Controllers
 */
class UserControlController extends ControllerBase
{
    public function initialize()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
    }

    public function indexAction()
    {
    }

    /**
     * Confirms an e-mail, if the user must change thier password then changes it
     */
    public function confirmEmailAction()
    {
        $code = $this->dispatcher->getParam('code');

        $confirmation = EmailConfirmations::findFirstByCode($code);

        if (!$confirmation) {
            return $this->dispatcher->forward([
                'controller' => 'index',
                'action' => 'index'
            ]);
        }

        if ($confirmation->confirmed != 'N') {
            return $this->dispatcher->forward([
                'controller' => 'session',
                'action' => 'login'
            ]);
        }

        $confirmation->confirmed = 'Y';

        $confirmation->user->active = 'Y';

        /**
         * Change the confirmation to 'confirmed' and update the user to 'active'
         */
        if (!$confirmation->save()) {
            foreach ($confirmation->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward([
                'controller' => 'index',
                'action' => 'index'
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
                'action' => 'changePassword'
            ]);
        }

        $this->flash->success('The email was successfully confirmed');

        return $this->dispatcher->forward([
            'controller' => 'users',
            'action' => 'index'
        ]);
    }

    public function resetPasswordAction()
    {
        $code = $this->dispatcher->getParam('code');

        $resetPassword = ResetPasswords::findFirstByCode($code);

        if (!$resetPassword) {
            return $this->dispatcher->forward([
                'controller' => 'index',
                'action' => 'index'
            ]);
        }

        if ($resetPassword->reset != 'N') {
            return $this->dispatcher->forward([
                'controller' => 'session',
                'action' => 'login'
            ]);
        }

        $resetPassword->reset = 'Y';

        /**
         * Change the confirmation to 'reset'
         */
        if (!$resetPassword->save()) {
            foreach ($resetPassword->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward([
                'controller' => 'index',
                'action' => 'index'
            ]);
        }

        /**
         * Identify the user in the application
         */
        $this->auth->authUserById($resetPassword->usersId);

        $this->flash->success('Please reset your password');

        return $this->dispatcher->forward([
            'controller' => 'users',
            'action' => 'changePassword'
        ]);
    }
}
