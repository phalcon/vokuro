<?php

namespace Modules\Companies\Forms;

use Phalcon\Forms\Form,
  Phalcon\Forms\Element\Text,
  Phalcon\Forms\Element\Hidden,
  Phalcon\Validation\Validator\PresenceOf,
  Phalcon\Validation\Validator\StringLength,
  Phalcon\Validation\Validator\Email,
  Phalcon\Validation\Validator\Identical;

class CompaniesForm extends Form
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
    // We don't need to add the ID when we are Adding a new Company, only when we are editing a new Company
    if (isset($options['edit'])) {
      // Make the ID hidden, users don't need to know that number
      $this->add(new Hidden("id"));
    }

    /*  Panel is Details */
    // name
    $companyname = new Text('name');
    $companyname->setLabel("Company Name");
    $companyname->setFilters(array('striptags', 'string'));
    $companyname->addValidators(
      [
        new PresenceOf(
          ['cancelOnFail' => true]
        ),
        new StringLength(
          ['min' => 2]
        )
      ]
    );
    $this->add($companyname);
    unset($companyname);

    $vat = new Text("vat_number");
    $vat->setLabel("VAT Number");
    $vat->setFilters(array('striptags', 'string'));
    $vat->addValidators(array(
        new PresenceOf(array(
            'message' => 'vat is required'
        ))
    ));
    $this->add($vat);
    unset($vat);

    $telephone = new Text("work_phone");
    $telephone->setLabel("Work Phone");
    $telephone->setFilters(array('striptags', 'string'));
    $telephone->addValidators(array(
        new PresenceOf(array(
            'message' => 'Telephone is required'
        ))
    ));
    $this->add($telephone);
    unset($telephone);

    $phone_mobile = new Text("mobile_phone");
    $phone_mobile->setLabel("Mobile Phone");
    $phone_mobile->setFilters(array('striptags', 'string'));
    $this->add($phone_mobile);
    unset($phone_mobile);

    $email = new Text("work_email");
    $email->setLabel("Email");
    $this->add($email);
    unset($email);

    /*  Panel is Address */
    $address_street = new Text("address1");
    $address_street->setLabel("Street");
    $this->add($address_street);
    unset($address_street);

    $address_number = new Text("house_number");
    $address_number->setLabel("House Number / App / Suite");
    $address_number->setFilters(array('striptags', 'string'));
    $this->add($address_number);
    unset($address_number);

    $house_number_addition = new Text("house_number_addition");
    $house_number_addition->setLabel("Addition");
    $house_number_addition->setFilters(array('striptags', 'string'));
    $this->add($house_number_addition);
    unset($house_number_addition);

    $address_postalcode = new Text("postalcode");
    $address_postalcode->setLabel("Postal Code");
    $address_postalcode->setFilters(array('striptags', 'string'));
    $this->add($address_postalcode);
    unset($address_postalcode);

    $city = new Text("city");
    $city->setLabel("city");
    $city->setFilters(array('striptags', 'string'));
    $city->addValidators(array(
      new PresenceOf(array(
        'message' => 'City is required'
      ))
    ));
    $this->add($city);
    unset($city);



  } /* initialize */
}