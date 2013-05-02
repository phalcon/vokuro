<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

/**
 * Vokuro\Models\Profiles
 *
 * All the users registered in the application
 */
class Profiles extends Model
{
	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var string
	 */
	public $name;

	public function initialize()
	{
		$this->hasMany('id', 'Vokuro\Models\Users', 'profilesId', array(
			'alias' => 'users',
			'foreignKey' => array(
				'message' => 'Profile cannot be deleted because it\'s used on Users'
			)
		));

		$this->hasMany('id', 'Vokuro\Models\Permissions', 'profilesId', array(
			'alias' => 'permissions'
		));
	}

}