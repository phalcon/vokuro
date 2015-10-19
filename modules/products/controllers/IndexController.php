<?php

namespace Modules\Products\Controllers;

use Phalcon\Mvc\Dispatcher;
use Modules\Products\Forms as ProductsForm;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class IndexController extends \Vokuro\Controllers\BaseController
{

  /**
   *  Initialize the Index Controller of the Products module
   */
  public function initialize() {
    $this->tag->setTitle('Manage your Products');
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
    $products = \Modules\Products\Models\Products::query()
      ->order('id DESC')
      ->execute();
    $paginator = new \Phalcon\Paginator\Adapter\Model(
      array(
        'data'  => $products,
        'limit' => 10,
        'page'  => $current_page
      )
    );
    $this->view->setVar('page', $paginator->getPaginate());
    unset($current_page, $products, $paginator);
  }  /* indexAction */

  /**
   * Shows the form to create a new product
   */
  public function newAction() {
    echo "new action called in IndexController!";
  } /* newAction*/

  /**
   *
   */
  public function addAction() {
    echo "add action called in IndexController!";
  } /* addAction */

  /**
   * Edits a product based on its id
   *
   * @param string $id
   */
  public function editAction($id = '') {
    echo "edit action called in IndexController!";
  } /* editAction */

  /**
   * Creates a new Product
   */
  public function createAction() {
    echo "create action called in IndexController!";
  }  /* createAction */

  /**
   * Saves The product from the edit form to the DataBase
   *
   * @param string $id
   */
  public
  function saveAction() {
    $dispatcher = new Dispatcher;
    if (!$this->request->isPost()) {
      $dispatcher->forward(array(
        'namespace'  => '\\Modules\\Products\\Controllers',
        'module'     => 'products',
        'controller' => 'index',
        'action'     => 'index'
      ));

      return false;
    } else {
      $form = new \Modules\Products\Forms\ProductsForm(null, array());
      $id = $this->request->getPost("id", "int");
      $product = \Modules\Products\Models\Products::findFirstById($id);
      if (!$product) {
        $this->flash->error("Product does not exist");

        return $this->response->redirect('products/index');
      }
      $data = $this->request->getPost();

      $form->bind($data, $product);
      if (!$form->isValid($data, $product)) {
        foreach ($form->getMessages() as $message) {
          $this->flash->error($message);
        }

        return $this->response->redirect('products/edit/' . $id);
      }

      if ($product->save() == false) {
        foreach ($product->getMessages() as $message) {
          $this->flash->error($message);
        }

        $this->response->redirect('products/edit/' . $id);
      }

      $form->clear();

      $this->flash->success("Product was Upppdated successfully");

      return $this->response->redirect('/products/index');
    }
  }  /* saveAction */

  /**
   * Deletes a product
   *
   * @param string $id
   */
  public function deleteAction($id) {
    echo "delete action called in IndexController!";
  }  /* deleteAction */

  /**
   *
   */
  public function multipleAction() {
    echo "multiple action called in IndexController!";
  } /* multipleAction */
}