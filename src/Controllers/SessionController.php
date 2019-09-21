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
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function initialize(): void
    {
        $this->view->setTemplateBefore('public');
    }

    public function indexAction(): void
    {
    }

    /**
     * Allow a user to signup to the system
     */
    public function signupAction()
    {
        $form = new SignUpForm();

        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost())) {
                $user = new Users([
                    'name'       => $this->request->getPost('name', 'striptags'),
                    'email'      => $this->request->getPost('email'),
                    'password'   => $this->security->hash($this->request->getPost('password')),
                    'profilesId' => 2,
                ]);

                if ($user->save()) {
                    return $this->dispatcher->forward([
                        'controller' => 'index',
                        'action'     => 'index',
                    ]);
                }

                foreach ($user->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            }
        }

        $this->view->setVar('form', $form);
    }

    /**
     * Starts a session in the admin backend
     */
    public function loginAction()
    {
        $form = new LoginForm();

        try {
            if (!$this->request->isPost()) {
                if ($this->auth->hasRememberMe()) {
                    return $this->auth->loginWithRememberMe();
                }
            } else {
                if ($form->isValid($this->request->getPost()) == false) {
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
    }

    /**
     * Shows the forgot password form
     */
    public function forgotPasswordAction(): void
    {
        $form = new ForgotPasswordForm();

        if ($this->request->isPost()) {
            // Send emails only is config value is set to true
            if ($this->getDI()->get('config')->useMail) {
                if ($form->isValid($this->request->getPost()) == false) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                } else {
                    $user = Users::findFirstByEmail($this->request->getPost('email'));
                    if (!$user) {
                        $this->flash->success('There is no account associated to this email');
                    } else {
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
            } else {
                $this->flash->warning(
                    'Emails are currently disabled. Change config key "useMail" to true to enable emails.'
                );
            }
        }

        $this->view->setVar('form', $form);
    }

    /**
     * Closes the session
     */
    public function logoutAction()
    {
        $this->auth->remove();

        return $this->response->redirect('index');
    }
}
