<?php

namespace Vokuro\Forms;

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\Hidden,
	Phalcon\Forms\Element\Password,
	Phalcon\Forms\Element\Submit,
	Phalcon\Forms\Element\Check,
	Phalcon\Validation\Validator\PresenceOf,
	Phalcon\Validation\Validator\Email,
	Phalcon\Validation\Validator\Identical,
	Phalcon\Validation\Validator\StringLength,
	Phalcon\Validation\Validator\Confirmation;

class SignUpForm extends Form
{

	public function initialize($entity=null, $options=null)
	{

		$name = new Text('name');

		$name->setLabel('Name');

		$name->addValidators(array(
			new PresenceOf(array(
				'message' => 'The name is required'
			))
		));

		$this->add($name);

		//Email
		$email = new Text('email');

		$email->setLabel('E-Mail');

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
		$password = new Password('password');

		$password->setLabel('Password');

		$password->addValidators(array(
			new PresenceOf(array(
				'message' => 'The password is required'
			)),
			new StringLength(array(
				'min' => 8,
				'messageMinimum' => 'Password is too short. Minimum 8 characters'
			)),
			new Confirmation(array(
				'message' => 'Password doesn\'t match confirmation',
				'with' => 'confirmPassword'
			))
		));

		$this->add($password);

		//Confirm Password
		$confirmPassword = new Password('confirmPassword');

		$confirmPassword->setLabel('Confirm Password');

		$confirmPassword->addValidators(array(
			new PresenceOf(array(
				'message' => 'The confirmation password is required'
			))
		));

		$this->add($confirmPassword);

		//Remember
		$terms = new Check('terms', array(
			'value' => 'yes'
		));

		$terms->setLabel('Accept terms and conditions');

		$terms->addValidator(
			new Identical(array(
				'value' => 'yes',
				'message' => 'Terms and conditions must be accepted'
			))
		);

		$this->add($terms);

		//CSRF
		$csrf = new Hidden('csrf');

		$csrf->addValidator(
			new Identical(array(
				'value' => $this->security->getSessionToken(),
				'message' => 'CSRF validation failed'
			))
		);

		$this->add($csrf);

		//Sign Up
		$this->add(new Submit('Sign Up', array(
			'class' => 'btn btn-success'
		)));

	}

	/**
	 * Prints messages for a specific element
	 */
	public function messages($name)
	{
		if ($this->hasMessagesFor($name)) {
			foreach ($this->getMessagesFor($name) as $message) {
				$this->flash->error($message);
			}
		}
	}

}