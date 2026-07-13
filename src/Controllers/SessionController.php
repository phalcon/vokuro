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

use Phalcon\Http\ResponseInterface;
use Vokuro\Forms\ForgotPasswordForm;
use Vokuro\Forms\LoginForm;
use Vokuro\Forms\SignUpForm;
use Vokuro\Models\ResetPasswords;
use Vokuro\Models\Users;
use Vokuro\Plugins\Auth\Exception as AuthException;

/**
 * Controller used handle non-authenticated session actions like login/logout,
 * user signup, and forgotten passwords
 */
class SessionController extends ControllerBase
{
    /**
     * Shows the forgot password form
     */
    public function forgotPasswordAction(): void
    {
        $form = new ForgotPasswordForm();

        if ($this->request->isPost()) {
            $this->handleForgotPassword($form);
        }

        $this->view->setVar('form', $form);
    }

    /**
     * The bare /session route has no page of its own; send it to the login form.
     */
    public function indexAction(): ResponseInterface
    {
        return $this->response->redirect('session/login');
    }
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function initialize(): void
    {
        $this->view->setTemplateBefore('auth');
    }

    /**
     * Starts a session in the admin backend
     */
    public function loginAction(): ?ResponseInterface
    {
        $form = new LoginForm();

        try {
            if (!$this->request->isPost()) {
                if ($this->auth->hasRememberMe()) {
                    $response = $this->auth->loginWithRememberMe();
                    if (null !== $response) {
                        return $response;
                    }
                }
            } else {
                if (!$form->isValid($this->request->getPost())) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error((string) $message);
                    }
                } else {
                    $this->auth->check([
                        'email'    => $this->request->getPost('email'),
                        'password' => $this->request->getPost('password'),
                        'remember' => $this->request->getPost('remember'),
                    ]);

                    return $this->response->redirect('users');
                }
            }
        } catch (AuthException $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->setVar('form', $form);

        return null;
    }

    /**
     * Closes the session
     */
    public function logoutAction(): ResponseInterface
    {
        $this->auth->remove();

        return $this->response->redirect('index');
    }

    /**
     * Allow a user to signup to the system
     */
    public function signupAction(): void
    {
        $form = new SignUpForm();

        if ($this->request->isPost() && $form->isValid($this->request->getPost())) {
            $user = new Users([
                'name'       => $this->request->getPost('name', 'striptags'),
                'email'      => $this->request->getPost('email'),
                'password'   => $this->security->hash($this->request->getPost('password')),
                'profilesId' => 2,
            ]);

            if ($user->save()) {
                $this->dispatcher->forward([
                    'controller' => 'index',
                    'action'     => 'index',
                ]);

                return;
            }

            foreach ($user->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
        }

        $this->view->setVar('form', $form);
    }

    /**
     * Processes the forgot-password submission and flashes the outcome.
     */
    private function handleForgotPassword(ForgotPasswordForm $form): void
    {
        if (!$this->getDI()->get('config')->useMail) {
            $this->flash->warning(
                'Emails are currently disabled. Change config key "useMail" to true to enable emails.'
            );

            return;
        }

        if (!$form->isValid($this->request->getPost())) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            return;
        }

        $user = Users::findFirstByEmail($this->request->getPost('email'));
        if (!$user) {
            $this->flash->success('There is no account associated to this email');

            return;
        }

        $resetPassword          = new ResetPasswords();
        $resetPassword->usersId = $user->id;
        if ($resetPassword->save()) {
            $this->flash->success('Success! Please check your messages for an email reset password');
        } else {
            foreach ($resetPassword->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
        }
    }
}
