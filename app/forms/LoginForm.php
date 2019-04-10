<?php
namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;

class LoginForm extends Form
{
    public function initialize()
    {
        // Email
        $email = new Text('email', [
            'class' => 'form-control',
            'placeholder' => 'E-mail'
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

        // Password
        $password = new Password('password', [
            'class' => 'form-control',
            'placeholder' => 'Password'
        ]);
        $password->addValidator(new PresenceOf([
            'message' => 'The password is required'
        ]));
        $password->clear();
        $this->add($password);

        // Remember
        $remember = new Check('remember', [
            'value' => 'yes'
        ]);

        $remember->setLabel('Remember');

        $this->add($remember);

        // CSRF
        $csrf = new Hidden('csrf');
        $csrf->addValidator(new Identical([
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        ]));
        $csrf->clear();
        $this->add($csrf);

        $this->add(new Submit('go', [
            'class' => 'btn btn-sm btn-primary btn-block',
            'value' => 'Login'
        ]));
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
