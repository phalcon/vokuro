<?php

namespace Modules\Invoices\Models;

class Invoices extends \Phalcon\Mvc\Model
{
  public $id;

  public $name;

  public $address;

//$this->belongsTo("gallery_item_id", "Vokuro\Models\GalleryItems", "id", array( "alias" => "GalleryItem"));
//$this->belongsTo("gallery_category_id", "Vokuro\Models\GalleryCategories", "id", array( "alias" => "GalleryCategory"));

  /**
   *
   */
  public function initialize() {
    $this->belongsTo(
      'relation_id',
      'Modules\Relations\Models\Relations',
      'id',
      array(
        'reusable' => true,
        'alias'    => 'customer'
      )
    );
    $this->belongsTo(
      'invoice_status_id',
      'Modules\Invoices\Models\InvoiceStatusses',
      'id',
      array(
        'reusable' => true,
        'alias'    => 'status'
      )
    );

  }// initialize

  /**
   * @return string
   */
  public function getSource() {
    return 'invoices';
  }// getSource

}