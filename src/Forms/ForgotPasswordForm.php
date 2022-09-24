<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vokuro\Forms;

use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

class ForgotPasswordForm extends Form
{
    public function initialize()
    {
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

        $this->add(new Submit('Send', [
            'class' => 'btn btn-primary',
        ]));
    }
}
