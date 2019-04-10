<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Vokuro\Forms\ChangePasswordForm;
use Vokuro\Forms\UsersForm;
use Vokuro\Models\Users;
use Vokuro\Models\PasswordChanges;

/**
 * Vokuro\Controllers\UsersController
 * CRUD to manage users
 */
class UsersController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
        $this->tag->setTitle('Users');
    }

    /**
     * Default action
     */
    public function indexAction()
    {
        // Breadcrumbs
        $this->view->breadcrumbs = "
        <li class='breadcrumb-item'><a href='/dashboard'><i class='fa fa-fw fa-cog'></i> User Panel</a></li>
        <li class='breadcrumb-item active'><i class='fas fa-user-secret'></i> Users</li>
        ";
        $users = Users::find();
        $this->view->users = $users;
    }


    /**
     * Default action
     */
    public function authorizationAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error("User is not found");
            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }
        // Breadcrumbs
        $this->view->breadcrumbs = "
        <li class='breadcrumb-item'><a href='/dashboard'><i class='fa fa-fw fa-cog'></i> User Panel</a></li>
        <li class='breadcrumb-item'><a href='/users'><i class='fas fa-user-secret'></i> Users</a></li>
        <li class='breadcrumb-item active'><i class='fas fa-sign-in-alt'></i> Authorization</li>
        ";
        $this->view->user = $user;
    }

    /**
     * Creates a user
     */
    public function createAction()
    {
        $form = new UsersForm(null);

        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {
                $user = new Users([
                    'name' => $this->request->getPost('name', 'striptags'),
                    'roleID' => $this->request->getPost('roleID', 'int'),
                    'email' => $this->request->getPost('email', 'email'),
                    'banned' => $this->request->getPost('banned'),
                    'suspended' => $this->request->getPost('suspended'),
                    'active' => $this->request->getPost('active')
                ]);

                if (!$user->save()) {
                    $this->flash->error($user->getMessages());
                } else {
                    $this->flash->success("User created");

                    Tag::resetInput();
                }
            }
        }
        // Breadcrumbs
        $this->view->breadcrumbs = "
        <li class='breadcrumb-item'><a href='/dashboard'><i class='fa fa-fw fa-cog'></i> User Panel</a></li>
        <li class='breadcrumb-item'><a href='/users'><i class='fas fa-user-secret'></i> Users</a></li>
        <li class='breadcrumb-item active'><i class='fas fa-plus-circle'></i> Create</li>
        ";
        $this->view->form = $form;
    }

    /**
     * Saves the user from the 'edit' action
     */
    public function editAction($id)
    {
        $user = Users::findFirstById($id);

        if (!$user) {
            $this->flash->error("User is not found");
            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }
        if ($this->request->isPost()) {
            $user->assign([
                'name' => $this->request->getPost('name', 'striptags'),
                'email' => $this->request->getPost('email', 'email'),
                'roleID' => $this->request->getPost('roleID', 'int'),
                'active' => $this->request->getPost('active')
            ]);
            $form = new UsersForm($user, [
                'edit' => true
            ]);
            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {
                if (!$user->save()) {
                    $this->flash->error($user->getMessages());
                } else {
                    $this->flash->success("User updated");
                }
            }
        }
        // Breadcrumbs
        $this->view->breadcrumbs = "
        <li class='breadcrumb-item'><a href='/dashboard'><i class='fa fa-fw fa-cog'></i> User Panel</a></li>
        <li class='breadcrumb-item'><a href='/users'><i class='fas fa-user-secret'></i> Users</a></li>
        <li class='breadcrumb-item active'><i class='fas fa-edit'></i> Edit</li>
        ";
        $this->view->user = $user;
        $this->view->form = new UsersForm($user, [
            'edit' => true
        ]);
    }

    /**
     * Deletes a user
     *
     * @param int $id
     */
    public function deleteAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error("User is not found");
            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }

        if (!$user->delete()) {
            $this->flash->error($user->getMessages());
        } else {
            $this->flash->success("user was deleted");
        }

        return $this->dispatcher->forward([
            'action' => 'index'
        ]);
    }

    /**
     * Users must use this action to change its password
     */
    public function changePasswordAction()
    {
        $form = new ChangePasswordForm();

        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {
                $user = $this->auth->getuser();

                $user->password = $this->security->hash($this->request->getPost('password'));
                $user->mustChangePassword = 'N';

                $passwordChange = new PasswordChanges();
                $passwordChange->userID = $user->id;
                $passwordChange->ipAddress = $this->request->getClientAddress();
                $passwordChange->userAgent = $this->request->getUserAgent();

                if (!$passwordChange->save() or !$user->save()) {
                    $this->flash->error($passwordChange->getMessages());
                } else {
                    $this->flash->success('Your password was successfully changed');

                    Tag::resetInput();
                }
            }
        }
        // Breadcrumbs
        $this->view->breadcrumbs = "
        <li class='breadcrumb-item'><a href='/dashboard'><i class='fa fa-fw fa-cog'></i> User Panel</a></li>
        <li class='breadcrumb-item active'><i class='fas fa-key'></i> Change Password</li>
        ";
        $this->view->form = $form;

        $this->tag->setTitle('Change Password');
    }
}
