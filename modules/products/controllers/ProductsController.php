<?php

namespace Modules\Products\Controllers;

use Phalcon\Mvc\Dispatcher;
use Modules\Products\Forms as ProductsForm;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ProductsController extends \Vokuro\Controllers\BaseController
{

  /**
   * ProductsController
   *
   */
  public function initialize() {
    $this->tag->setTitle('Manage your Products');
    //$this->view->setTemplateBefore('private');
    parent::initialize();
  }

  /**
   *
   */
  public function browseAction() {
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
    echo "test";
    $this->view->form = new ProductsForm(null, array());
    $this->view->pick('index/form');
  } /* newAction*/


  /**
   *
   */
  public function addAction() {
    $output = [];

    // add form.
    $form = new \Modules\Products\Forms\ProductsForm(null, array());
    $this->view->setVar('form', $form);

    if ($this->request->isPost()) {
      if (!$form->isValid($_POST)) {
        $output['err_msg'] = '';
        foreach ($form->getMessages() as $message) {
          echo "what is my message?";
          var_dump($message);
          $this->flash->error("Message: " . $message);
        }
        unset($message);
      } else {
        // passed validated post
        $data['name'] = htmlspecialchars($this->request->getPost('name', array('trim')));
        $data['address'] = htmlspecialchars($this->request->getPost('address', 'trim'));
        $products = new \Modules\Products\Models\Products();
        $products_save = $products->save($data);
        if ($products_save === false) {
          $this->flash->error("Unable to insert");
          foreach ($products->getMessages() as $message) {
            $this->flash->warning("Message: " . $message);
          }
          unset($message);
        } else {
          $this->flash->success("Saved success! The Id is: " . $products->id);
          $this->response->redirect('products');
        }
        unset($data, $products, $products_save);
      }
    }

    $this->view->setVars($output);
    unset($form, $output);
    $this->view->pick('index/form');
  } /* addAction */

  /**
   * Edits a product based on its id
   *
   * @param string $id
   */
  public function editAction($id = '') {
    $output = [];

    $product = \Modules\Products\Models\Products::findFirstById($id);
    if (!$product) {
      $this->flash->error("Product was not found");

      return $this->response->redirect('products');
    }
    // Add the form to the View
    $form = new \Modules\Products\Forms\ProductsForm($product, ['edit' => true, 'id' => $id]);
    $this->view->setVar('form', $form);

    $product = new \Modules\Products\Models\Products();
    $data = $this->request->getPost();

    if (!$this->request->isPost()) {
    } else {
      if (!$form->isValid($data, $product)) {
        foreach ($form->getMessages() as $message) {
          $this->flash->warning("Message: " . $message);
        }
        unset($message);
      } else {
        // passed validated post
        $form->bind($this->request->getPost(), $product);
        $products_save = $product->save();
        if ($product === false) {
          $this->flash->error("Unable to update:");
          foreach ($product->getMessages() as $message) {
            $this->flash->warning("Message " . $message);
          }
          unset($message);
        } else {
          $this->flash->success("Saved success! The id is " . $id);
          $this->response->redirect('products');
        }
        unset($data, $products, $products_save);
      }
    }
    unset($form, $output);
    $this->view->pick('index/form');
  } /* editAction */

  /**
   * Creates a new Product
   */
  public function createAction() {
    $dispatcher = new Dispatcher;
    if (!$this->request->isPost()) {
      echo "no post!";
      $dispatcher->forward(array(
        'namespace'  => '\\Modules\\Products\\Controllers',
        'module'     => 'products',
        'controller' => 'products',
        'action'     => 'browse'
      ));
      //return false;
    } else {
      $form = new \Modules\Products\Forms\ProductsForm(null, array());
      $product = new \Modules\Products\Models\Products();

      $data = $this->request->getPost();

      if (!$form->isValid($data, $product)) {
        foreach ($form->getMessages() as $message) {
          echo "what is my message?";
          var_dump($message);
          exit();
          $this->flash->error($message);
        }
        return $this->response->redirect('products/add');
      }

      if ($product->save() == false) {
        foreach ($product->getMessages() as $message) {
          if ($message == "product_types_id is required") {
            $message = "You havvve to fill the product type";
            $this->flash->error($message);
          } else {
            /*
             *  Other Messages can be:
             *  - Price is required
             **/
            $this->flash->error($message);
          }
        }
        $this->response->redirect('products/add');

        return false;
      }

      $form->clear();

      $this->flash->success("Product was created successfully");

      return $this->response->redirect('/products');
    }
  }  /* createAction */

  /**
   * Saves The product from the edit form to the DataBase
   *
   * @param string $id
   */
  public
  function saveAction() {
    $dispatcher = new Dispatcher;
    /*
     *  If there is no posting of a form, redirect to the products index (browse action)
     *  It needs to 'forward', so the wrong url does not stay in the browser's address bar
     *  It needs to 'forward', so the wrong url does not stay in the browser's address bar
     **/
    if (!$this->request->isPost()) {

      $dispatcher->forward(array(
        'namespace'  => '\\Modules\\Products\\Controllers',
        'module'     => 'products',
        'controller' => 'products',
        'action'     => 'browse'
      ));
      return false;

    } else {
      /*
       *  Form was posted, let's attach it to the form, the product and let's see if it is a valid posting
       *  Otherwise return back to the form and show an error message, why the form is not valid
       **/
      $form = new \Modules\Products\Forms\ProductsForm(null, array());
      $id = $this->request->getPost("id", "int");
      $product = \Modules\Products\Models\Products::findFirstById($id);

      /*
       *  No product found? Interesting. Do some logging for the administrators!
       **/
      if (!$product) {
        $this->flash->error("Product does not exist");
        return $this->response->redirect('products');
      }

      $data = $this->request->getPost();

      $form->bind($data, $product);

      /*
       *  Is the form valid?
       **/
      if (!$form->isValid($data, $product)) {
        /*
         *  The form is not valid, show error message and return to the edit form!
         *  Keep the values in the edit form, so they can be corrected
         **/
        foreach ($form->getMessages() as $message) {
          if ($message == "product_types_id is required") {
            $message = "You havvve to fill the product type";
            $this->flash->error($message);
          } else {
            /*
             *  Other Messages can be:
             *  - Price is required
             **/
            $this->flash->error($message);
          }
        }
        return $this->response->redirect('products/edit/' . $id);
      }

      /*
       *  Did the product get saved? Why not? Show error messages
       **/
      if ($product->save() == false) {
        foreach ($product->getMessages() as $message) {
          $this->flash->error($message);
        }
        $this->response->redirect('products/edit/' . $id);
      }

      $form->clear();

      $this->flash->success("Product was Upppdated successfully");

      return $this->response->redirect('/products');
    }
  }  /* saveAction */

  /**
   * Deletes a product
   *
   * @param string $id
   */
  public function deleteAction($id) {

    $products = \Modules\Products\Models\Products::findFirstById($id);
    if (!$products) {
      $this->flash->error("Product was not found");

      $this->response->redirect("products");
    }

    if (!$products->delete()) {
      foreach ($products->getMessages() as $message) {
        $this->flash->error($message);
      }

      $this->response->redirect("products");
    }

    $this->flash->success("Product was deleted");

    $this->response->redirect("products");
  }  /* deleteAction */

  /**
   *
   */
  public function multipleAction() {
    $ids = $this->request->getPost('id');
    $connection = $this->_dependencyInjector->getShared('db');
    $config = $this->_dependencyInjector->getShared('config');

    if ($this->request->isPost()) {
      if (is_array($ids)) {
        foreach ($ids as $id) {
          // to use database abstraction layer, you have to manually add table prefix.
          $connection->delete($config->database->tablePrefix . 'products', 'id = ' . $id);
        }
      }
    }

    unset($config, $connection, $id, $ids);

    $this->response->redirect('products');
  } /* multipleAction */
}