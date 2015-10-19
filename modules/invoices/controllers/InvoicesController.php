<?php
namespace Modules\Invoices\Controllers;

use Phalcon\Mvc\Dispatcher;
use Modules\Invoices\Forms as InvoicesForm;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

use \Phalcon\Mvc\Controller;


class InvoicesController extends \Vokuro\Controllers\BaseController
{

  /**
   *
   */
  public function initialize() {
    $this->tag->setTitle('Manage your Invoices');
    //$this->view->setTemplateBefore('private');
    parent::initialize();
  }

  /**
   *
   */
  public function browseAction() {
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
  }  /* browseAction */

  /**
   * Shows the form to create a new invoice
   */
  public function newAction() {
    $this->view->form = new \Modules\Invoices\Forms\InvoicesForm(null, array());
  }  /* newAction */

  /**
   *
   */
  public function addAction() {
    $output = [];

    // add form.
    $form = new \Modules\Invoices\Forms\InvoicesForm(null, array());
    $this->view->setVar('form', $form);

    if ($this->request->isPost()) {
      if (!$form->isValid($_POST)) {
        $output['err_msg'] = '';
        foreach ($form->getMessages() as $message) {
          $this->flash->error("Message: " . $message);
        }
        unset($message);
      } else {
        // passed validated post
        $data['name'] = htmlspecialchars($this->request->getPost('name', array('trim')));
        $data['address'] = htmlspecialchars($this->request->getPost('address', 'trim'));
        $invoices = new \Modules\Invoices\Models\Invoices();
        $invoices_save = $invoices->save($data);
        if ($invoices_save === false) {
          $this->flash->error("Unable to insert");
          foreach ($invoices->getMessages() as $message) {
            $this->flash->warning("Message: " . $message);
          }
          unset($message);
        } else {
          $this->flash->success("Saved success! The Id is: " . $invoices->id);
          $this->response->redirect('invoices');
        }
        unset($data, $invoices, $invoices_save);
      }
    }
    $this->view->setVars($output);
    unset($form, $output);
  } /* addAction */

  /**
   * @param string $id
   */
  public function editAction($id = '') {
    $output = [];

    $invoices = \Modules\Invoices\Models\Invoices::findFirstById($id);

    // Add the form to the View
    $form = new \Modules\Invoices\Forms\InvoicesForm($invoices, ['edit' => true, 'id' => $id]);
    $this->view->setVar('form', $form);

    if ($this->request->isPost()) {
      if (!$form->isValid($_POST)) {
        $output['err_msg'] = '';
        foreach ($form->getMessages() as $message) {
          $this->flash->warning("Message: " . $message);
        }
        unset($message);
      } else {
        // passed validated post
        $form->bind($this->request->getPost(), $invoices);
        $invoices_save = $invoices->save();
        if ($invoices === false) {
          $this->flash->error("Unable to update:");
          foreach ($invoices->getMessages() as $message) {
            $this->flash->warning("Message " . $message);
          }
          unset($message);
        } else {
          $this->flash->success("Saved success! The id is " . $id);
          $this->response->redirect('invoices');
        }
        unset($data, $myinvoices, $invoices_save);
      }
    }

    $this->view->setVars($output);
    unset($form, $output);
  } /* editAction */

  /**
   * Creates a new invoice
   */
  public function createAction() {
    $dispatcher = new Dispatcher;
    if (!$this->request->isPost()) {
      $dispatcher->forward(array(
        'namespace'  => '\\Modules\\Invoices\\Controllers',
        'module'     => 'invoices',
        'controller' => 'invoices',
        'action'     => 'browse'
      ));

      return false;
    } else {
      $form = new \Modules\Invoices\Forms\InvoicesForm(null, array());
      $invoice = new \Modules\Invoices\Models\Invoices();

      $data = $this->request->getPost();

      if (!$form->isValid($data, $invoice)) {
        foreach ($form->getMessages() as $message) {
          $this->flash->error($message);
        }

        return $this->response->redirect('invoices/add');
      }

      if ($invoice->save() == false) {
        foreach ($invoice->getMessages() as $message) {
          $this->flash->error($message);
        }

        $this->response->redirect('invoices/add');
      }

      $form->clear();

      $this->flash->success("Invoice was created successfully");

      return $this->response->redirect('/invoices');
    }
  } /* createAction */

  /**
   * Saves The invoice from the edit form to the DataBase
   *
   * @param string $id
   */
  public function saveAction() {
    $dispatcher = new Dispatcher;
    if (!$this->request->isPost()) {
      $dispatcher->forward(array(
        'namespace'  => '\\Modules\\Invoices\\Controllers',
        'module'     => 'invoices',
        'controller' => 'invoices',
        'action'     => 'browse'
      ));

      return false;
    } else {
      $form = new \Modules\Invoices\Forms\InvoicesForm(null, array());
      //$form = new InvoicesForm;
      $id = $this->request->getPost("id", "int");
      $invoice = \Modules\Invoices\Models\Invoices::findFirstById($id);
      //$invoice = new \Modules\Invoices\Models\Invoices();

      $data = $this->request->getPost();

      $form->bind($data, $invoice);

      //$form->setData($request->getPost());

      if (!$form->isValid($data, $invoice)) {
        foreach ($form->getMessages() as $message) {
          $this->flash->error($message);
        }

        return $this->response->redirect('invoices/add');
      }

      if ($invoice->save() == false) {
        foreach ($invoice->getMessages() as $message) {
          $this->flash->error($message);
        }

        $this->response->redirect('invoices/add');
      }

      $form->clear();

      $this->flash->success("Invoice was Saved successfully");

      return $this->response->redirect('/invoices');
    }
  }  /* saveAction */

  /**
   * Deletes an invoice
   *
   * @param string $id
   */
  public function deleteAction($id) {

    $invoice = \Modules\Invoices\Models\Invoices::findFirstById($id);
    if (!$invoice) {
      $this->flash->error("Invoice was not found");
      $this->response->redirect("invoices");
    }

    if (!$invoice->delete()) {
      foreach ($invoice->getMessages() as $message) {
        $this->flash->error($message);
      }

      $this->response->redirect("invoices");
    }

    $this->flash->success("Invoice was deleted");

    $this->response->redirect("invoices");
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
          $connection->delete($config->database->tablePrefix . 'invoices', 'id = ' . $id);
        }
      }
    }
    unset($config, $connection, $id, $ids);
    $this->response->redirect('invoices');
  } /* multipleAction */
}