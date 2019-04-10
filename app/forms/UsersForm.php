<?php
namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Vokuro\Models\Roles;

class UsersForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $name = new Text('name', [
            'placeholder' => 'Name'
        ]);
        $name->addValidators([
            new PresenceOf([
                'message' => 'The name is required'
            ])
        ]);
        $this->add($name);
        $email = new Text('email', [
            'placeholder' => 'e-mail'
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

        $roles = Roles::find([
            'active = :active:',
            'bind' => [
                'active' => 'Y'
            ]
        ]);
        $this->add(new Select('roleID', $roles, [
            'using' => [
                'id',
                'name'
            ],
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        ]));

        $this->add(new Select('banned', [
            'Y' => 'Yes',
            'N' => 'No'
        ]));

        $this->add(new Select('suspended', [
            'Y' => 'Yes',
            'N' => 'No'
        ]));

        $this->add(new Select('active', [
            'Y' => 'Yes',
            'N' => 'No'
        ]));
        // CSRF
        $csrf = new Hidden('csrf');
        $csrf->addValidator(new Identical([
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        ]));
        $csrf->clear();
        $this->add($csrf);
    }
}
