<?php

/*
  +------------------------------------------------------------------------+
  | Vökuró                                                                 |
  +------------------------------------------------------------------------+
  | Copyright (c) 2016-present Phalcon Team (https://www.phalconphp.com)   |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file LICENSE.txt.                             |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
*/

namespace Vokuro\Controllers;

use Phalcon\Tag;
use Vokuro\Models\Profiles;
use Vokuro\Forms\ProfilesForm;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
 * CRUD to manage profiles
 * Vokuro\Controllers\ProfilesController
 * @package Vokuro\Controllers
 */
class ProfilesController extends ControllerBase
{
    /**
     * Default action. Set the private (authenticated) layout (layouts/private.volt)
     */
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new ProfilesForm();
    }

    /**
     * Searches for profiles
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\Profiles', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $profiles = Profiles::find($parameters);
        if (count($profiles) == 0) {
            $this->flash->notice("The search did not find any profiles");

            return $this->dispatcher->forward([
                "action" => "index"
            ]);
        }

        $paginator = new Paginator([
            "data" => $profiles,
            "limit" => 10,
            "page" => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Creates a new Profile
     */
    public function createAction()
    {
        if ($this->request->isPost()) {
            $profile = new Profiles([
                'name' => $this->request->getPost('name', 'striptags'),
                'active' => $this->request->getPost('active')
            ]);

            if (!$profile->save()) {
                $this->flash->error($profile->getMessages());
            } else {
                $this->flash->success("Profile was created successfully");
            }
        }

        $this->view->form = new ProfilesForm(null);
        $this->view->form->clear();
    }

    /**
     * Edits an existing Profile
     *
     * @param int $id
     */
    public function editAction($id)
    {
        $profile = Profiles::findFirstById($id);
        if (!$profile) {
            $this->flash->error("Profile was not found");
            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }

        if ($this->request->isPost()) {
            $profile->assign([
                'name' => $this->request->getPost('name', 'striptags'),
                'active' => $this->request->getPost('active')
            ]);

            if (!$profile->save()) {
                $this->flash->error($profile->getMessages());
            } else {
                $this->flash->success("Profile was updated successfully");
            }
        }

        $this->view->form = new ProfilesForm($profile, [
            'edit' => true
        ]);
        $this->view->form->clear();

        $this->view->profile = $profile;
    }

    /**
     * Deletes a Profile
     *
     * @param int $id
     */
    public function deleteAction($id)
    {
        $profile = Profiles::findFirstById($id);
        if (!$profile) {
            $this->flash->error("Profile was not found");

            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }

        if (!$profile->delete()) {
            $this->flash->error($profile->getMessages());
        } else {
            $this->flash->success("Profile was deleted");
        }

        return $this->dispatcher->forward([
            'action' => 'index'
        ]);
    }
}
