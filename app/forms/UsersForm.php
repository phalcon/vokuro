<?php

/*
  +------------------------------------------------------------------------+
  | Vökuró                                                                 |
  +------------------------------------------------------------------------+
  | Copyright (c) 2016-present Phalcon Team (https://www.phalconphp.com)   |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file LICENSE.txt.                             |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
*/

namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Vokuro\Models\Profiles;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Email as EmailText;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * Vokuro\Forms\UsersForm
 * @package Vokuro\Forms
 */
class UsersForm extends Form
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
           // 'placeholder' => 'Name'
        ]);       
        $name->setLabel('Name');
        $name->addValidators([
            new PresenceOf([
                'message' => 'The name is required'
            ])
        ]);
        $this->add($name);

        $email = new EmailText('email', [
        ]);       
        $email->setLabel('Email');  
        $email->addValidators([
            new PresenceOf([
                'message' => 'The e-mail is required'
            ]),
            new Email([
                'message' => 'The e-mail is not valid'
            ])
        ]);
        $this->add($email);

        $profiles = Profiles::find([
            'active = :active:',
            'bind' => [
                'active' => 'Y'
            ]
        ]);

        $profilesId = new Select('profilesId', $profiles, [
            'using' => [
                'id',
                'name'
            ],
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
        ]);
        $profilesId->setLabel('Profile');
        $this->add($profilesId);
        
        
        $banned = new Select('banned', [
            'Y' => 'Yes',
            'N' => 'No'
        ]);
        $banned->setLabel('Banned');
        $this->add($banned);

        
        $suspended = new Select('suspended', [
            'Y' => 'Yes',
            'N' => 'No'
        ]);
        $suspended->setLabel('Suspended');
        $this->add($suspended);
        

        $active = new Select('active', [
            'Y' => 'Yes',
            'N' => 'No'
        ]);
        $active->setLabel('Active');
        $this->add($active);
    }
}
