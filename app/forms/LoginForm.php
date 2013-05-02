<?php

namespace Vokuro\Forms;

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\Password,
	Phalcon\Forms\Element\Submit,
	Phalcon\Forms\Element\Check,
	Phalcon\Forms\Element\Hidden,
	Phalcon\Validation\Validator\PresenceOf,
	Phalcon\Validation\Validator\Email,
	Phalcon\Validation\Validator\Identical;

use Vokuro\Models\Profiles;

class LoginForm extends Form
{

	public function initialize()
	{
		//Email
		$email = new Text('email', array(
			'placeholder' => 'Email'
		));

		$email->addValidators(array(
			new PresenceOf(array(
				'message' => 'The e-mail is required'
			)),
			new Email(array(
				'message' => 'The e-mail is not valid'
			))
		));

		$this->add($email);

		//Password
		$password = new Password('password', array(
			'placeholder' => 'Password'
		));

		$password->addValidator(
			new PresenceOf(array(
				'message' => 'The password is required'
			))
		);

		$this->add($password);

		//Remember
		$remember = new Check('remember', array(
			'value' => 'yes'
		));

		$remember->setLabel('Remember me');

		$this->add($remember);

		//CSRF
		$csrf = new Hidden('csrf');

		$csrf->addValidator(
			new Identical(array(
				'value' => $this->security->getSessionToken(),
				'message' => 'CSRF validation failed'
			))
		);

		$this->add($csrf);

		$this->add(new Submit('go', array(
			'class' => 'btn btn-success'
		)));
	}

}