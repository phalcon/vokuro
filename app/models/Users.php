<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
* Vokuro\Models\Users
* All the Users registered in the application
*/
class Users extends Model
{

  /**
  *
  * @var integer
  */
  public $id;

  /**
  *
  * @var string
  */
  public $name;

  /**
  *
  * @var string
  */
  public $email;

  /**
  *
  * @var string
  */
  public $password;

  /**
  *
  * @var string
  */
  public $mustChangePassword;

  /**
  *
  * @var string
  */
  public $roleID;

  /**
  *
  * @var string
  */
  public $banned;

  /**
  *
  * @var string
  */
  public $suspended;

  /**
  *
  * @var string
  */
  public $active;

  /**
  * Before create the user assign a password
  */
  public function beforeValidationOnCreate()
  {
    if (empty($this->password)) {

      // Generate a plain temporary password
      $tempPassword = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(12)));

      // The user must change its password in first login
      $this->mustChangePassword = 'Y';

      // Use this password as default
      $this->password = $this->getDI()
      ->getSecurity()
      ->hash($tempPassword);
    } else {
      // The user must not change its password in first login
      $this->mustChangePassword = 'N';
    }

    // The account must be confirmed via e-mail
    // Only require this if emails are turned on in the config, otherwise account is automatically active
    if ($this->getDI()->get('config')->useMail) {
      $this->active = 'N';
    } else {
      $this->active = 'Y';
    }

    // The account is not suspended by default
    $this->suspended = 'N';

    // The account is not banned by default
    $this->banned = 'N';
  }

  /**
  * Validate that emails are unique across Users
  */
  public function validation()
  {
    $validator = new Validation();

    $validator->add('email', new Uniqueness([
      "message" => "The email is already registered"
    ]));

    return $this->validate($validator);
  }

  public function initialize()
  {
    $this->belongsTo('roleID', __NAMESPACE__ . '\Roles', 'id', [
      'alias' => 'role',
      'reusable' => true
    ]);

    $this->hasMany('id', __NAMESPACE__ . '\SuccessLogins', 'userID', [
      'alias' => 'successLogins',
      'foreignKey' => [
        'message' => 'User cannot be deleted because he/she has activity in the system'
      ]
    ]);

    $this->hasMany('id', __NAMESPACE__ . '\PasswordChanges', 'userID', [
      'alias' => 'passwordChanges',
      'foreignKey' => [
        'message' => 'User cannot be deleted because he/she has activity in the system'
      ]
    ]);

    $this->hasMany('id', __NAMESPACE__ . '\ResetPasswords', 'userID', [
      'alias' => 'resetPasswords',
      'foreignKey' => [
        'message' => 'User cannot be deleted because he/she has activity in the system'
      ]
    ]);
  }
}
