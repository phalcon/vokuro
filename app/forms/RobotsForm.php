<?php
namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Vokuro\Models\Parts;

class RobotsForm extends Form
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

        $year = new Select('year', $options['years'], [
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

        if (isset($options['edit']) && $options['edit']) {
            $partList = new Text('partList', [
                'placeholder' => 'Parts',
                'value' => $options['partNames'],
            ]);
        } else {
            $partList = new Text('partList', [
                'placeholder' => 'Parts'
            ]);
        }


        $partList->addValidators([
            new PresenceOf([
                'message' => 'At least one part is required'
            ])
        ]);

        $this->add($partList);;
    }
}
