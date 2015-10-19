<?php

namespace Modules\Companies\Models;

class Companies extends \Phalcon\Mvc\Model
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
  public function initialize() {
    // $this->belongsTo();// more info about relations, see the documentation.
  }// initialize

  /**
   * @return string
   */
  public function getSource() {
    return 'companies';
  }// getSource

}