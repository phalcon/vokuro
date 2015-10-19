<?php

namespace Modules\Relations\Models;

class Relations extends \Phalcon\Mvc\Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $work_phone;

    /**
     * @var string
     */
    public $address1;

    /**
     * @var string
     */
    public $city;

    public $address2;
    public $house_number;
    public $house_number_addition;
    public $postal_code;

    public $state;
    public $country_id;
    public $mobile_phone;
    public $work_email;
    public $vat_number;

    /**
     *
     */
    public function initialize()
    {
        // $this->belongsTo();// more info about relations, see the documentation.
        // Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(
            array(
                'year',
                'price'
            )
        );

        // Skips only when inserting
        $this->skipAttributesOnCreate(
            array(
                'created_at'
            )
        );

        // Skips only when updating
        $this->skipAttributesOnUpdate(
            array(
                'updated_at'
            )
        );

    }// initialize

    /**
     * @return string
     */
    public function getSource()
    {
        return 'relations';
    }// getSource

    public function beforeCreate()
    {
        // Set the creation date
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        // Set the modification date
        $this->updated_at = date('Y-m-d H:i:s');
    }
}