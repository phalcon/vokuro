<?php

namespace Modules\Invoices\Forms;

use Phalcon\Forms\Form,
  Phalcon\Forms\Element\Text,
  Phalcon\Forms\Element\Numeric,
  Phalcon\Forms\Element\Date,
  Phalcon\Forms\Element\Hidden,
  Phalcon\Validation\Validator\PresenceOf,
  Phalcon\Validation\Validator\StringLength,
  Phalcon\Validation\Validator\Email,
  Phalcon\Validation\Validator\Identical;

use Phalcon\Forms\Element\Select as Select;

class InvoicesForm extends Form
{

  /**
   * @param string $db
   * @param array  $options
   */
  public function initialize($entity = null, array $options = []) {

    // csrf
    /*
        $csrf = new Hidden('csrf');
        $csrf->addValidator(
          new Identical(
            array(
              'value'   => $this->security->getSessionToken(),
              'message' => 'CSRF validation failed'
            )
          )
        );
        $this->add($csrf);
        unset($csrf);
    */

    // id
    // We don't need to add the ID when we are Adding a new Invoice, only when we are editing a new Company
    if (isset($options['edit'])) {
      // Make the ID hidden, users don't need to know that number
      $this->add(new Hidden("id"));
    }

    // invoice_number
    $invoice_number = new Numeric('invoice_number');
    $invoice_number->setLabel("Invoice Number");
    $invoice_number->addValidators(
      [
        new PresenceOf(
          ['cancelOnFail' => true]
        ),
        new StringLength(
          ['min' => 2]
        )
      ]
    );
    $this->add($invoice_number);
    unset($invoice_number);

    $customer = new Select('relation_id', \Modules\Companies\Models\Companies::find(), array(
      'using'      => array('id', 'name'),
      'useEmpty'   => true,
      'emptyText'  => '---- please fill company ---',
      'emptyValue' => ''
    ));
    $customer->setLabel("Customer");
    $this->add($customer);

    $invoice_status = new Select('invoice_status_id', \Modules\Invoices\Models\InvoiceStatusses::find(), array(
      'using'      => array('id', 'name'),
      'useEmpty'   => true,
      'emptyText'  => '---- please fill status ---',
      'emptyValue' => ''
    ));
    $invoice_status->setLabel("Status");
    $this->add($invoice_status);
    unset($invoice_status);

    // invoice_date
    $invoice_date = new Date('invoice_date');
    $invoice_date->setLabel("Date");
    $this->add($invoice_date);
    unset($invoice_date);

    // invoice_total
    $invoice_total = new Numeric('amount');
    $invoice_total->setLabel("Total");
    $this->add($invoice_total);
    unset($invoice_total);
    /*
    More invoice fields and their types!
    */


  } /* initialize */


}