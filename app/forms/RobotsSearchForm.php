<?php
namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Vokuro\Models\Parts;

class RobotsSearchForm extends Form
{

    public function initialize($entity = null, $options = null)
    {

        // In edition the id is hidden
        if (isset($options['edit']) && $options['edit']) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
        }

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

        $type = new Text('type', [
            'placeholder' => 'Type'
        ]);

        $type->addValidators([
            new PresenceOf([
                'message' => 'The type is required'
            ])
        ]);

        $this->add($type);

        $years = range(1900, (int) date('Y'));

        $year = new Select('year', $years, [
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        ]);

        $year->addValidators([
            new PresenceOf([
                'message' => 'The year is required'
            ])
        ]);

        $this->add($year);

        $parts = Parts::find();

        $this->add(new Select('parts_id', $parts, [
            'using' => [
                'id',
                'name'
            ],
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        ]));
    }
}
