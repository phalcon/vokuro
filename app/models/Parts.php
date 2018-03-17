<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;

class Parts extends Model
{
    public $id;

    public $name;


    /**
     * Sets table name
     *
     * @return string
     */
    public function getSource()
    {
        return 'parts';
    }

    public function initialize()
    {
        $this->hasMany(
            'id',
            __NAMESPACE__ . '\Parts2Robots',
            'parts_id', [
                'alias' => 'parts2robots',
                'foreignKey' => [
                    'message' => 'Cannot be deleted because it has activity in the system'
                ]
            ]
        );
    }
}