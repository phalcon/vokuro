<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;

/**
* Vokuro\Models\Roles
* All the role levels in the application. Used in conjenction with ACL lists
*/
class Roles extends Model
{

  /**
  * ID
  * @var integer
  */
  public $id;

  /**
  * Name
  * @var string
  */
  public $name;

  /**
  * Define relationships to users and Permissions
  */
  public function initialize()
  {
    $this->hasMany('id', __NAMESPACE__ . '\Users', 'roleID', [
      'alias' => 'users',
      'foreignKey' => [
        'message' => 'Role cannot be deleted because it\'s used on Users'
      ]
    ]);

    $this->hasMany('id', __NAMESPACE__ . '\Permissions', 'roleID', [
      'alias' => 'permissions',
      'foreignKey' => [
        'action' => Relation::ACTION_CASCADE
      ]
    ]);
  }
}
