<?php
declare(strict_types=1);

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Vokuro\Forms\ProfilesForm;
use Vokuro\Models\Profiles;

/**
 * Vokuro\Controllers\ProfilesController
 * CRUD to manage profiles
 */
final class ProfilesController extends ControllerBase
{
    /**
     * Default action. Set the private (authenticated) layout (layouts/private.volt)
     */
    public function initialize(): void
    {
        $this->view->setTemplateBefore('private');
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction(): void
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

        $this->view->page = $paginator->paginate();
    }

    /**
     * Creates a new Profile
     */
    public function createAction(): void
    {
        if ($this->request->isPost()) {
            $profile = new Profiles([
                'name' => $this->request->getPost('name', 'striptags'),
                'active' => $this->request->getPost('active')
            ]);

            if (!$profile->save()) {
                foreach ($profile->getMessages() as $message) {
                    $this->flash->error((string)$message);
                }
            } else {
                $this->flash->success("Profile was created successfully");
            }
        }

        $this->view->form = new ProfilesForm(null);
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
                foreach ($profile->getMessages() as $message) {
                    $this->flash->error((string)$message);
                }
            } else {
                $this->flash->success("Profile was updated successfully");
            }
        }

        $this->view->form = new ProfilesForm(null, [
            'edit' => true
        ]);

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
            foreach ($profile->getMessages() as $message) {
                $this->flash->error((string)$message);
            }
        } else {
            $this->flash->success("Profile was deleted");
        }

        return $this->dispatcher->forward([
            'action' => 'index'
        ]);
    }
}
