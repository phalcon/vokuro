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
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;

class SignUpForm extends Form
{

  public function initialize($entity = null, $options = null)
  {
    $name = new Text('name', [
      'class' => 'form-control',
      'placeholder' => 'name'
    ]);
    $name->addValidators([
      new PresenceOf([
        'message' => 'The name is required'
      ])
    ]);
    $this->add($name);

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
    $password->addValidators([
      new PresenceOf([
        'message' => 'The password is required'
      ]),
      new StringLength([
        'min' => 8,
        'messageMinimum' => 'Password is too short. Minimum 8 characters'
      ]),
      new Confirmation([
        'message' => 'Password doesn\'t match confirmation',
        'with' => 'confirmPassword'
      ])
    ]);
    $this->add($password);

    // Confirm Password
    $confirmPassword = new Password('confirmPassword', [
      'class' => 'form-control',
      'placeholder' => 'Confirm Password'
    ]);
    $confirmPassword->addValidators([
      new PresenceOf([
        'message' => 'The confirmation password is required'
      ])
    ]);
    $this->add($confirmPassword);

    // Remember
    $terms = new Check('terms', [
      'value' => 'yes'
    ]);

    $terms->setLabel('Accept terms and conditions');

    $terms->addValidator(new Identical([
      'value' => 'yes',
      'message' => 'Terms and conditions must be accepted'
    ]));

    $this->add($terms);

    // CSRF
    $csrf = new Hidden('csrf');
    $csrf->addValidator(new Identical([
      'value' => $this->security->getSessionToken(),
      'message' => 'CSRF validation failed'
    ]));
    $csrf->clear();
    $this->add($csrf);

    // Sign Up
    $this->add(new Submit('Sign Up', [
      'class' => 'btn btn-sm btn-primary btn-block'
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
