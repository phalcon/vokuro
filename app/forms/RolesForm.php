<?php
namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Identical;

class RolesForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $id = new Hidden('id');
        $this->add($id);
        $name = new Text('name', [
            'placeholder' => 'Name'
        ]);
        $name->addValidators([
            new PresenceOf([
                'message' => 'The name is required'
            ])
        ]);
        $this->add($name);
        $this->add(new Select(
            'active',
            [
                'Y' => 'Yes',
                'N' => 'No'
            ]
        ));
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
