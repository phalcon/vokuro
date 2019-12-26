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

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Forms\ChangePasswordForm;
use Vokuro\Forms\UsersForm;
use Vokuro\Models\PasswordChanges;
use Vokuro\Models\Users;

/**
 * Vokuro\Controllers\UsersController
 * CRUD to manage users
 */
class UsersController extends ControllerBase
{
    public function initialize(): void
    {
        $this->view->setTemplateBefore('private');
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction(): void
    {
        $this->view->setVar('form', new UsersForm());
        $this->assets->collection("js")->addJs("/js/privateUsers.js", true, true);
    }

    /**
     * Searches for users
     */
    public function searchAction(): void
    {
        $builder = Criteria::fromInput($this->getDI(), Users::class, $this->request->getQuery());

        $count = Users::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any users');
            $this->dispatcher->forward([
                'action' => 'index',
            ]);

            return;
        }

        $paginator = new Paginator([
            'builder'  => $builder->createBuilder(),
            'limit' => 10,
            'page'  => $this->request->getQuery('page', 'int', 1),
        ]);

        $this->view->setVar('page', $paginator->paginate());
    }

    /**
     * Creates a User
     */
    public function createAction(): void
    {
        $form = new UsersForm();

        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            } else {
                $user = new Users([
                    'name'       => $this->request->getPost('name', 'striptags'),
                    'profilesId' => $this->request->getPost('profilesId', 'int'),
                    'email'      => $this->request->getPost('email', 'email'),
                ]);

                if (!$user->save()) {
                    foreach ($user->getMessages() as $message) {
                        $this->flash->error((string) $message);
                    }
                } else {
                    $this->flash->success("User was created successfully");
                }
            }
        }

        $this->view->setVar('form', $form);
    }

    /**
     * Saves the user from the 'edit' action
     *
     * @param int $id
     */
    public function editAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error('User was not found.');

            return $this->dispatcher->forward([
                'action' => 'index',
            ]);
        }

        $form = new UsersForm($user, [
            'edit' => true,
        ]);

        if ($this->request->isPost()) {
            $user->assign([
                'name'       => $this->request->getPost('name', 'striptags'),
                'profilesId' => $this->request->getPost('profilesId', 'int'),
                'email'      => $this->request->getPost('email', 'email'),
                'banned'     => $this->request->getPost('banned'),
                'suspended'  => $this->request->getPost('suspended'),
                'active'     => $this->request->getPost('active'),
            ]);

            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            } else {
                if (!$user->save()) {
                    foreach ($user->getMessages() as $message) {
                        $this->flash->error((string) $message);
                    }
                } else {
                    $this->flash->success('User was updated successfully.');
                }
            }
        }

        $this->view->setVars([
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error('User was not found.');

            return $this->dispatcher->forward([
                'action' => 'index',
            ]);
        }

        if (!$user->delete()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
        } else {
            $this->flash->success('User was deleted.');
        }

        return $this->dispatcher->forward([
            'action' => 'index',
        ]);
    }

    /**
     * Users must use this action to change its password
     */
    public function changePasswordAction(): void
    {
        $form = new ChangePasswordForm();

        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            } else {
                $user = $this->auth->getUser();

                $user->password           = $this->security->hash($this->request->getPost('password'));
                $user->mustChangePassword = 'N';

                $passwordChange            = new PasswordChanges();
                $passwordChange->user      = $user;
                $passwordChange->ipAddress = $this->request->getClientAddress();
                $passwordChange->userAgent = $this->request->getUserAgent();

                if (!$passwordChange->save()) {
                    foreach ($passwordChange->getMessages() as $message) {
                        $this->flash->error((string) $message);
                    }
                } else {
                    $this->flash->success('Your password was successfully changed');
                }
            }
        }

        $this->view->setVar('form', $form);
    }
}
