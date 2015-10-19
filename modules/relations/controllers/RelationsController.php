<?php

namespace Modules\Relations\Controllers;

use Phalcon\Mvc\Dispatcher;
use Modules\Relations\Forms as RelationsForm;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

use \Phalcon\Mvc\Controller;


class RelationsController extends \Vokuro\Controllers\BaseController
{

    /**
     *
     */
    public function initialize()
    {
        $this->tag->setTitle('Manage your Relations');
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
        $relations = \Modules\Relations\Models\Relations::query()
            ->order('id DESC')
            ->execute();

        $this->view->setVar('form', $form);
        unset($form);

        $current_page = (int)$this->request->get('page', null, 1);
        $relations = \Modules\Relations\Models\Relations::query()
            ->order('id DESC')
            ->execute();

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                'data' => $relations,
                'limit' => 10,
                'page' => $current_page
            )
        );

        $this->view->setVar('page', $paginator->getPaginate());
        unset($current_page, $relations, $paginator);
    }  /* browseAction */

    /**
     * @param string $id
     */
    public function editAction($id = '')
    {
        $output = [];

        $relation = \Modules\Relations\Models\Relations::findFirstById($id);
        $form = new \Modules\Relations\Forms\RelationsForm($relation, ['edit' => true, 'id' => $id]);

        if (!$this->request->isPost()) {
            // Add the form to the View
            $this->view->setVar('form', $form);
        }
        else
        {
            if (!$form->isValid($_POST)) {
                $output['err_msg'] = '';
                foreach ($form->getMessages() as $message) {
                    $this->flash->warning("Message: " . $message);
                }
                unset($message);
            } else {
                // passed validated post
                $form->bind($this->request->getPost(), $relation);
                $relations_save = $relation->save();
                if ($relation === false) {
                    $this->flash->error("Unable to update:");
                    foreach ($relation->getMessages() as $message) {
                        $this->flash->warning("Message " . $message);
                    }
                    unset($message);
                } else {
                    $this->flash->success("Saved success! The id is " . $id);
                    $this->response->redirect('relations');
                }
                unset($data, $myrelations, $relations_save);
            }
        }

        $this->view->setVars($output);
        unset($form, $output);
        //$this->view->pick('index/form');
    } /* editAction */

    /**
     * Creates a new relation
     */
    public function createAction()
    {
        $output = [];
        // add form.
        $form = new \Modules\Relations\Forms\RelationsForm(null, array());
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
                $relation = new \Modules\Relations\Models\Relations();
                $data = $this->request->getPost();
                $form = new \Modules\Relations\Forms\RelationsForm(null, array());
                $form->bind($data, $relation);

                if (!$form->isValid($data, $relation)) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                    return $this->response->redirect('relations/create');
                }
                // passed validated post
                $data['name'] = htmlspecialchars($this->request->getPost('name', array('trim')));
                $data['address1'] = htmlspecialchars($this->request->getPost('address1', 'trim'));
                $data['user_id'] =1;
                $data['company_id'] =1;

                //dpm($data);
/*
[name] => jkhkjhohohyo
[id_number] => 978976786876
[vat_number] => i7867856786
[website] => ghlygtototyytoyt
[work_phone] => 678678686
[address1] => ioytoytyotoytuot
[address2] => 67868
[city] => yugtgtiptyot
[state] => t6tyuytyutuy
[postal_code] => t78565hj
[first_name] => hghjjh
[last_name] => yutuytuyt
[email] => doe@hotmail.com
[phone] => 7897897897987987
[private_notes] => hjkhkjhjkhkjh
 **/

                $relation_save = $relation->save($data);
                if ($relation_save === false) {
                    $this->flash->error("Unable to create the relation:");
                    foreach ($relation->getMessages() as $message) {
                        $this->flash->warning("Message: " . $message);
                    }
                    unset($message);
                } else {
                    $this->flash->success("Saved success! The Id is: " . $relation->id);
                    $this->response->redirect('relations/browse');
                }
                unset($data, $relations, $relations_save);
            }
        }
        $this->view->setVars($output);
        unset($form, $output);
    } /* createAction */

    /**
     * Deletes a relation
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $relation = \Modules\Relations\Models\Relations::findFirstById($id);
        if (!$relation) {
            $this->flash->error("Relation was not found");
            $this->response->redirect("relations");
        }

        if (!$relation->delete()) {
            foreach ($relation->getMessages() as $message) {
                $this->flash->error($message);
            }
            $this->response->redirect("relations");
        }

        $this->flash->success("Relation was deleted");

        $this->response->redirect("relations");
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
                    $connection->delete($config->database->tablePrefix . 'relations', 'id = ' . $id);
                }
            }
        }
        unset($config, $connection, $id, $ids);
        $this->response->redirect('relations');
    } /* multipleAction */
}