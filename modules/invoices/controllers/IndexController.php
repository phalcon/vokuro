<?php

namespace Modules\Invoices\Controllers;

use Phalcon\Mvc\Dispatcher;
use Modules\Invoices\Forms as InvoicesForm;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class IndexController extends \Vokuro\Controllers\BaseController
{

  /**
   *  Initialize the Index Controller of the Invoices module
   */
  public function initialize() {
    $this->tag->setTitle('Manage your Invoices');
    parent::initialize();
  }

  /**
   *  You should never get to this action, because the module has its own controller
   *  This action is just here to catch wrong routes.
   */
  public function indexAction() {
    // generate some form for delete action
    $form = new \Phalcon\Forms\Form();
    $csrf = new \Phalcon\Forms\Element\Hidden('csrf', ['value' => $this->security->getToken()]);
    $csrf->addValidator(
      new \Phalcon\Validation\Validator\Identical(
        array(
          'value'   => $this->security->getSessionToken(),
          'message' => 'CSRF validation failed'
        )
      )
    );
    $form->add($csrf);

    $this->view->setVar('form', $form);
    unset($form);

    $current_page = (int)$this->request->get('page', null, 1);
    $invoices = \Modules\Invoices\Models\Invoices::query()
      ->order('id DESC')
      ->execute();
    $paginator = new \Phalcon\Paginator\Adapter\Model(
      array(
        'data'  => $invoices,
        'limit' => 10,
        'page'  => $current_page
      )
    );
    $this->view->setVar('page', $paginator->getPaginate());
    unset($current_page, $invoices, $paginator);
  }  /* indexAction */

}