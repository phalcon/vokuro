<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @var int
     */
    public $year;


    /**
     * Sets table name
     *
     * @return string
     */
    public function getSource()
    {
        return 'robots';
    }

    public function initialize()
    {
        $this->hasMany(
            'id',
            __NAMESPACE__ . '\Parts2Robots',
            'robots_id', [
                'alias' => 'parts2robots',
                'foreignKey' => [
                    'message' => 'Cannot be deleted because it has activity in the system'
                ]
            ]
        );

        $this->hasManyToMany(
            'id',
            __NAMESPACE__ . '\Parts2Robots',
            'robots_id', 'parts_id',
            __NAMESPACE__ . '\Parts',
            'id', [
                'alias' => 'parts'
            ]
        );
    }
}