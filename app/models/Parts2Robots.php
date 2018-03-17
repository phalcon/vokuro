<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;

class Parts2Robots extends Model
{
    public $id;

    public $robots_id;

    public $parts_id;

    /**
     * @var string
     */
    public $created_at;


    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        // Timestamp the confirmaton
        $this->created_at = date('Y-m-d H:i:s');
    }


    /**
     * Sets table name
     *
     * @return string
     */
    public function getSource()
    {
        return 'parts2robots';
    }


    public function initialize()
    {
        $this->belongsTo(
            'robots_id',
            __NAMESPACE__ . '\Robots',
            'id', [
                'alias' => 'robot',
            ]
        );

        $this->belongsTo(
            'parts_id',
            __NAMESPACE__ . '\Parts',
            'id', [
                'alias' => 'part',
            ]
        );
    }
}