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

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;

class ProfilesForm extends Form
{
    /**
     * @param null $entity
     * @param array $options
     */
    public function initialize($entity = null, array $options = [])
    {
        if (!empty($options['edit'])) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
        }

        $this->add($id);

        $name = new Text('name', [
            'placeholder' => 'Name',
        ]);
        $name->addValidators([
            new PresenceOf([
                'message' => 'The name is required',
            ]),
        ]);

        $this->add($name);

        $this->add(new Select('active', [
            'Y' => 'Yes',
            'N' => 'No',
        ]));
    }
}
