<?php

namespace Modules\Products\Models;

class Products extends \Phalcon\Mvc\Model
{
  public $id;

  public $name;

  /**
   * Products initializer
   */
  public function initialize() {
    $this->belongsTo(
      'product_types_id',
      'Modules\Products\Models\ProductTypes',
      'id',
      array(
        'reusable' => true,
        'alias'    => 'productTypes'
      )
    );
  }

  /**
   * @return string
   */
  public function getSource() {
    return 'products';
  }// getSource

  /**
   * Returns a human representation of 'active'
   *
   * @return string
   */
  public function getActiveDetail() {
    if ($this->active == 'Y') {
      return 'Yes';
    }

    return 'No';
  }


}