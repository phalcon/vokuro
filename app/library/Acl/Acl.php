<?php
namespace Vokuro\Acl;

use Phalcon\Plugin;
use Phalcon\Acl\Adapter\Memory as AclMemory;
use Phalcon\Acl\Role as AclRole;
use Phalcon\Acl\Component as AclResource;
use Vokuro\Models\Roles;

/**
* Vokuro\Acl\Acl
*/
class Acl extends Plugin
{

  /**
  * The ACL Object
  *
  * @var \Phalcon\Acl\Adapter\Memory
  */
  private $acl;

  /**
  * The file path of the ACL cache file.
  *
  * @var string
  */
  private $filePath;

  /**
  * Define the resources that are considered "private". These controller => actions require authentication.
  *
  * @var array
  */
  private $privateResources = array();

  const APC_STORE_KEY = 'Vokuro-acl';

  /**
  * Human-readable descriptions of the actions used in {@see $privateResources}
  *
  * @var array
  */
  private $actionDescriptions = [
    'index' => 'Access',
    'search' => 'Search',
    'create' => 'Create',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'changePassword' => 'Change password'
  ];

  /**
  * Checks if a controller is private or not
  *
  * @param string $controllerName
  * @return boolean
  */
  public function isPrivate($controllerName)
  {
    $controllerName = strtolower($controllerName);
    return isset($this->privateResources[$controllerName]);
  }

  /**
  * Checks if the current role is allowed to access a resource
  *
  * @param string $role
  * @param string $controller
  * @param string $action
  * @return boolean
  */
  public function isAllowed($role, $controller, $action)
  {
    return $this->getAcl()->isAllowed($role, $controller, $action);
  }

  /**
  * Returns the ACL list
  *
  * @return \Phalcon\Acl\Adapter\Memory
  */
  public function getAcl()
  {
    // Check if the ACL is already created
    if (is_object($this->acl)) {
      return $this->acl;
    }

    // Check if the ACL is in APC
    if (function_exists('apc_fetch')) {
      $acl = apc_fetch(self::APC_STORE_KEY);
      if (is_object($acl)) {
        $this->acl = $acl;
        return $acl;
      }
    }

    $filePath = $this->getFilePath();

    // Check if the ACL is already generated
    if (!file_exists($filePath)) {
      $this->acl = $this->rebuild();
      return $this->acl;
    }

    // Get the ACL from the data file
    $data = file_get_contents($filePath);
    $this->acl = unserialize($data);

    // Store the ACL in APC
    if (function_exists('apc_store')) {
      apc_store(self::APC_STORE_KEY, $this->acl);
    }

    return $this->acl;
  }

  /**
  * Returns the permissions assigned to a role
  *
  * @param Roles $role
  * @return array
  */
  public function getPermissions(Roles $role)
  {
    $permissions = [];
    foreach ($role->getPermissions() as $permission) {
      $permissions[$permission->resource . '.' . $permission->action] = true;
    }
    return $permissions;
  }

  /**
  * Returns all the resources and their actions available in the application
  *
  * @return array
  */
  public function getResources()
  {
    return $this->privateResources;
  }

  /**
  * Returns the action description according to its simplified name
  *
  * @param string $action
  * @return string
  */
  public function getActionDescription($action)
  {
    if (isset($this->actionDescriptions[$action])) {
      return $this->actionDescriptions[$action];
    } else {
      return $action;
    }
  }

  /**
  * Rebuilds the access list into a file
  *
  * @return \Phalcon\Acl\Adapter\Memory
  */
  public function rebuild()
  {
    $acl = new AclMemory();

    $acl->setDefaultAction(\Phalcon\Acl::DENY);

    // Register roles

    $roles = Roles::find([
      'active = :active:',
      'bind' => [
        'active' => 'Y'
      ]
    ]);
    foreach ($roles as $role) {
      $acl->addRole(new AclRole($role->name));
    }

    foreach ($this->privateResources as $resource => $actions) {
      $acl->addComponent(new AclResource($resource), $actions);
    }

    // Grant access to private area to role Users
    foreach ($roles as $role) {

      // Grant permissions in "permissions" model
      foreach ($role->getPermissions() as $permission) {
        $acl->allow($role->name, $permission->resource, $permission->action);
      }

      // Always grant these permissions
      $acl->allow($role->name, 'users', 'changePassword');
    }

    $filePath = $this->getFilePath();

    if (touch($filePath) && is_writable($filePath)) {

      file_put_contents($filePath, serialize($acl));

      // Store the ACL in APC
      if (function_exists('apc_store')) {
        apc_store(self::APC_STORE_KEY, $acl);
      }
    } else {
      $this->flash->error(
        'The user does not have write permissions to create the ACL list at ' . $filePath
      );
    }

    return $acl;
  }


  /**
  * Set the acl cache file path
  *
  * @return string
  */
  protected function getFilePath()
  {
    if (!isset($this->filePath)) {
      $this->filePath = rtrim($this->config->application->cacheDir, '\\/') . '/acl/data.txt';
    }

    return $this->filePath;
  }

  /**
  * Adds an array of private resources to the ACL object.
  *
  * @param array $resources
  */
  public function addPrivateResources(array $resources) {
    if (count($resources) > 0) {
      $this->privateResources = array_merge($this->privateResources, $resources);
      if (is_object($this->acl)) {
        $this->acl = $this->rebuild();
      }
    }
  }
}
