<?php


namespace Modules\Products\Forms;

use Phalcon\Forms\Form,
  Phalcon\Forms\Element\Text,
  Phalcon\Forms\Element\Hidden,
  Phalcon\Validation\Validator\PresenceOf,
  Phalcon\Validation\Validator\Email,
  Phalcon\Validation\Validator\Numericality,
  Phalcon\Validation\Validator\StringLength,
  Phalcon\Validation\Validator\Identical;

use Phalcon\Forms\Element\Select as Select;


class ProductsForm extends Form
{

  /**
   * Initialize the products form
   *
   * @param string $db
   * @param array  $options
   */
  public function initialize($entity = null, array $options = []) {
    // id
    // We don't need to add the ID when we are Adding a new Product, only when we are editing a new Product
    if (isset($options['edit']) && $options['edit'] === true && isset($options['id'])) {
      $this->add(new Hidden('id', ['value' => $options['id']]));
    }

    // name
    $name = new Text('name');
    $name->setLabel("Name");
    $name->setFilters(array('striptags', 'string'));
    $name->addValidators(
      [
        new PresenceOf(
          ['cancelOnFail' => true]
        ),
        new StringLength(
          ['min' => 2]
        )
      ]
    );
    $this->add($name);
    unset($name);

    $producttype = new Select('product_types_id', \Modules\Products\Models\ProductTypes::find(), array(
      'using'      => array('id', 'name'),
      'useEmpty'   => true,
      'emptyText'  => '---- please fill product type ---',
      'emptyValue' => ''
    ));
    $producttype->setLabel("Product Type");
    $this->add($producttype);

    $price = new Text("price");
    $price->setLabel("Price");
    $price->setFilters(array('float'));
    $price->addValidators(array(
      new PresenceOf(array(
        'message' => 'Price is required'
      )),
      new Numericality(array(
        'message' => 'Price Has to be a number'
      ))
    ));
    $this->add($price);
  }  /* initialize */
}