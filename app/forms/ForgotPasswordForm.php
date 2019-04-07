<?php
namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class ForgotPasswordForm extends Form
{

    public function initialize()
    {
        $email = new Text('email', [
            'placeholder' => 'Email'
        ]);

        $email->addValidators([
            new PresenceOf([
                'message' => 'The e-mail is required'
            ]),
            new Email([
                'message' => 'The e-mail is not valid'
            ])
        ]);

        $this->add($email);

        $this->add(new Submit('Send', [
            'class' => 'btn btn-primary'
        ]));
    }
}
