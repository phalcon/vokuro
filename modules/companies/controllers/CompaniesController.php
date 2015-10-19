<?php

namespace Modules\Companies\Controllers;

use Phalcon\Mvc\Dispatcher;
use Modules\Companies\Forms as CompaniesForm;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

use \Phalcon\Mvc\Controller;


class CompaniesController extends \Vokuro\Controllers\BaseController
{

    /**
     *
     */
    public function initialize()
    {
        $this->tag->setTitle('Manage your Companies');
        $this->view->setTemplateBefore('private');
        parent::initialize();
    }

    /**
     * Default action, shows the search form
     */
    public function browseAction()
    {
        // generate some form for delete action
        $form = new \Phalcon\Forms\Form();

        /*
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
        */
        $companies = \Modules\Companies\Models\Companies::query()
            ->order('id DESC')
            ->execute();

        $this->view->setVar('form', $form);
        unset($form);

        $current_page = (int)$this->request->get('page', null, 1);
        $companies = \Modules\Companies\Models\Companies::query()
            ->order('id DESC')
            ->execute();

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                'data' => $companies,
                'limit' => 10,
                'page' => $current_page
            )
        );

        $this->view->setVar('page', $paginator->getPaginate());
        unset($current_page, $companies, $paginator);
    }  /* browseAction */

    /**
     * @param string $id
     */
    public function editAction($id = '')
    {
        $output = [];
        $companies = \Modules\Companies\Models\Companies::findFirstById($id);

        // Add the form to the View
        $form = new \Modules\Companies\Forms\CompaniesForm($companies, ['edit' => true, 'id' => $id]);
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
                $form->bind($this->request->getPost(), $companies);
                $companies_save = $companies->save();
                if ($companies === false) {
                    $this->flash->error("Unable to update:");
                    foreach ($companies->getMessages() as $message) {
                        $this->flash->warning("Message " . $message);
                    }
                    unset($message);
                } else {
                    $this->flash->success("Saved success! The id is " . $id);
                    $this->response->redirect('companies');
                }
                unset($data, $mycompanies, $companies_save);
            }
        }

        $this->view->setVars($output);
        unset($form, $output);
        $this->view->pick('index/form');
    } /* editAction */

    /**
     * Creates a new company
     */
    public function createAction()
    {
        $output = [];
        // add form.
        $form = new \Modules\Companies\Forms\CompaniesForm(null, array());
        $this->view->setVar('form', $form);

        if (!$this->request->isPost()) {
            //$this->view->pick('index/form');
        } else {
            if (!$form->isValid($_POST)) {
                $output['err_msg'] = '';
                foreach ($form->getMessages() as $message) {
                    $this->flash->error("Message: " . $message);
                }
                unset($message);
            } else {
                $company = new \Modules\Companies\Models\Companies();
                $data = $this->request->getPost();
                $form = new \Modules\Companies\Forms\CompaniesForm(null, array());
                $form->bind($data, $company);

                if (!$form->isValid($data, $company)) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                    return $this->response->redirect('companies/create');
                }

                // passed validated post
                $data['name'] = htmlspecialchars($this->request->getPost('name', array('trim')));
                $data['address1'] = htmlspecialchars($this->request->getPost('address1', 'trim'));
/*
    [name] => uiououou
    [vat_number] => oiuoiu087898797
    [work_phone] => hjjlh8079879798
    [mobile_phone] => 97987979797987
    [work_email] => hjoui@hotmail.com
    [address] => 8789798798
    [house_number] => hjjklho0807
    [house_number_addition] => 9879798
    [postalcode] => 97897jjhk
    [city] => jkjkkjhkj
    [address1] =>
 **/

                $company_save = $company->save($data);
                if ($company_save === false) {
                    $this->flash->error("Unable to insert");
                    foreach ($company->getMessages() as $message) {
                        $this->flash->warning("Message: " . $message);
                    }
                    unset($message);
                } else {
                    $this->flash->success("Saved success! The Id is: " . $company->id);
                    $this->response->redirect('companies/browse');
                }
                unset($data, $companies, $companies_save);
            }
        }
        $this->view->setVars($output);
        unset($form, $output);
    } /* createAction */

    /**
     * Saves The company from the edit form to the DataBase
     *
     * @param string $id
     */
    public function saveAction()
    {
        $dispatcher = new Dispatcher;
        if (!$this->request->isPost()) {
            $dispatcher->forward(array(
                'namespace' => '\\Modules\\Companies\\Controllers',
                'module' => 'companies',
                'controller' => 'index',
                'action' => 'index'
            ));

            return false;
        } else {
            $form = new \Modules\Companies\Forms\CompaniesForm(null, array());
            //$form = new CompaniesForm;
            $id = $this->request->getPost("id", "int");
            $company = \Modules\Companies\Models\Companies::findFirstById($id);
            //$company = new \Modules\Companies\Models\Companies();

            $data = $this->request->getPost();

            $form->bind($data, $company);

            //$form->setData($request->getPost());

            if (!$form->isValid($data, $company)) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->response->redirect('companies/add');
            }

            if ($company->save() == false) {
                foreach ($company->getMessages() as $message) {
                    $this->flash->error($message);
                }

                $this->response->redirect('companies/add');
            }

            $form->clear();

            $this->flash->success("Company was Savvvved successfully");

            return $this->response->redirect('/companies');
        }
    }  /* saveAction */

    /**
     * Deletes a company
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $company = \Modules\Companies\Models\Companies::findFirstById($id);
        if (!$company) {
            $this->flash->error("Company was not found");
            $this->response->redirect("companies");
        }

        if (!$company->delete()) {
            foreach ($company->getMessages() as $message) {
                $this->flash->error($message);
            }
            $this->response->redirect("companies");
        }

        $this->flash->success("Company was deleted");

        $this->response->redirect("companies");
    }  /* deleteAction */

    /**
     *
     */
    public function multipleAction()
    {
        $ids = $this->request->getPost('id');
        $connection = $this->_dependencyInjector->getShared('db');
        $config = $this->_dependencyInjector->getShared('config');

        if ($this->request->isPost()) {
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    // to use database abstraction layer, you have to manually add table prefix.
                    $connection->delete($config->database->tablePrefix . 'companies', 'id = ' . $id);
                }
            }
        }
        unset($config, $connection, $id, $ids);
        $this->response->redirect('companies');
    } /* multipleAction */
}