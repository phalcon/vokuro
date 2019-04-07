<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Vokuro\Forms\RolesForm;
use Vokuro\Models\Roles;
use Vokuro\Models\Permissions;

/**
* Vokuro\Controllers\RolesController
* CRUD to manage Roles
*/
class RolesController extends ControllerBase
{

  /**
  * Default action. Set the private (authenticated) layout (layouts/private.volt)
  */
  public function initialize()
  {
    $this->view->setTemplateBefore('private');
    $this->tag->setTitle('Roles');
  }

  /**
  * Default action
  */
  public function indexAction()
  {
    // Breadcrumbs
    $this->view->breadcrumbs = "
    <li class='breadcrumb-item'><a href='/dashboard'><i class='fa fa-fw fa-cog'></i> User Panel</a></li>
    <li class='breadcrumb-item active'><i class='fas fa-layer-group'></i> Roles</li>
    ";
    $roles = Roles::find();
    $this->view->roles = $roles;
  }

  /**
  * Creates a new Role
  */
  public function createAction()
  {
    $form = new RolesForm(null);
    if ($this->request->isPost()) {
      if ($form->isValid($this->request->getPost()) == false) {
        foreach ($form->getMessages() as $message) {
          $this->flashSession->error($message);
        }
        return $this->response->redirect('/roles/create');
      }else{
        $role = new Roles([
          'name' => $this->request->getPost('name', 'striptags'),
          'active' => $this->request->getPost('active')
        ]);
        if ($role->save()) {
          $this->flashSession->success("The role is created");
        }
      }
      return $this->response->redirect('/roles');
    }
    // Breadcrumbs
    $this->view->breadcrumbs = "
    <li class='breadcrumb-item'><a href='/dashboard'><i class='fa fa-fw fa-cog'></i> User Panel</a></li>
    <li class='breadcrumb-item'><a href='/roles'><i class='fas fa-layer-group'></i> Roles</a></li>
    <li class='breadcrumb-item active'><i class='fas fa-plus-circle'></i> Create</li>
    ";
    $this->view->form = $form;
  }

  /**
  * Edits an existing Roles
  *
  * @param int $id
  */
  public function editAction($id)
  {
    $role = Roles::findFirstById($id);
    if (!$role) {
      $this->flash->error("The role is not found");
      return $this->dispatcher->forward([
        'action' => 'index'
      ]);
    }
    $form = new RolesForm($role);
    if ($this->request->isPost()) {
      if ($form->isValid($this->request->getPost()) == false) {
        foreach ($form->getMessages() as $message) {
          $this->flashSession->error($message);
        }
      } else {
        $role->assign([
          'name' => $this->request->getPost('name', 'striptags'),
          'active' => $this->request->getPost('active')
        ]);
        if ($role->save()) {
          $this->flashSession->success("The role is updated");
          return $this->response->redirect('/roles');
        }
      }
      return $this->response->redirect('/roles/edit/'.$id);
    }
    // Breadcrumbs
    $this->view->breadcrumbs = "
    <li class='breadcrumb-item'><a href='/dashboard'><i class='fa fa-fw fa-cog'></i> User Panel</a></li>
    <li class='breadcrumb-item'><a href='/roles'><i class='fas fa-layer-group'></i> Roles</a></li>
    <li class='breadcrumb-item active'><i class='fas fa-edit'></i> Edit</li>
    ";
    $this->view->form = $form;
    $this->view->role = $role;
  }

  public function editPermissionAction($id)
  {
    $role = Roles::findFirstById($id);
    if (!$role) {
      $this->flash->error("The role is not found");
      return $this->dispatcher->forward([
        'action' => 'index'
      ]);
    }

    if ($this->request->isPost()) {
      // Deletes the current permissions
      $role->getPermissions()->delete();
      // Save the new permissions
      foreach ($this->request->getPost('permissions') as $permission) {
        $parts = explode('.', $permission);
        $permission = new Permissions();
        $permission->roleID = $role->id;
        $permission->resource = $parts[0];
        $permission->action = $parts[1];
        $permission->save();
      }
      $this->flashSession->success('Permissions updated');
      return $this->response->redirect('/roles');
    }
    // Breadcrumbs
    $this->view->breadcrumbs = "
    <li class='breadcrumb-item'><a href='/dashboard'><i class='fa fa-fw fa-cog'></i> User Panel</a></li>
    <li class='breadcrumb-item'><a href='/roles'><i class='fas fa-layer-group'></i> Roles</a></li>
    <li class='breadcrumb-item active'><i class='fas fa-edit'></i> Edit</li>
    ";
    // Rebuild the ACL with
    $this->acl->rebuild();
    // Pass the current permissions to the view
    $this->view->permissions = $this->acl->getPermissions($role);
    $this->view->role = $role;
  }

  /**
  * Deletes a Role
  *
  * @param int $id
  */
  public function deleteAction($id)
  {
    $role = Roles::findFirstById($id);
    if (!$role) {

      $this->flash->error("The role is not found");

      return $this->dispatcher->forward([
        'action' => 'index'
      ]);
    }

    if (!$role->delete()) {
      $this->flash->error($role->getMessages());
    } else {
      $this->flash->success("Role was deleted");
    }

    return $this->dispatcher->forward([
      'action' => 'index'
    ]);
  }
}
