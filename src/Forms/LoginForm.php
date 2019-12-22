<?php
declare(strict_types=1);

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Vokuro\Forms;

use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\PresenceOf;

class LoginForm extends Form
{
    public function initialize()
    {
        // Email
        $email = new Text('email', [
            'placeholder' => 'Email',
        ]);

        $email->addValidators([
            new PresenceOf([
                'message' => 'The e-mail is required',
            ]),
            new Email([
                'message' => 'The e-mail is not valid',
            ]),
        ]);

        $this->add($email);

        // Password
        $password = new Password('password', [
            'placeholder' => 'Password',
        ]);
        $password->addValidator(new PresenceOf([
            'message' => 'The password is required',
        ]));
        $password->clear();

        $this->add($password);

        // Remember
        $remember = new Check('remember', [
            'value' => 'yes',
            'id'    => 'login-remember',
        ]);
        $remember->setLabel('Remember me');

        $this->add($remember);

        // CSRF
        $csrf = new Hidden('csrf');
        $csrf->addValidator(new Identical([
            'value'   => $this->security->getRequestToken(),
            'message' => 'CSRF validation failed',
        ]));
        $csrf->clear();

        $this->add($csrf);
        $this->add(new Submit('Login', [
            'class' => 'btn btn-primary',
        ]));
    }
}
