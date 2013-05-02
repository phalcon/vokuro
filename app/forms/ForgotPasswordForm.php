<?php

namespace Vokuro\Forms;

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\Submit,
	Phalcon\Validation\Validator\PresenceOf,
	Phalcon\Validation\Validator\Email;

use Vokuro\Models\Profiles;

class ForgotPasswordForm extends Form
{

	public function initialize()
	{
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

		$this->add(new Submit('Send', array(
			'class' => 'btn btn-primary'
		)));
	}

}