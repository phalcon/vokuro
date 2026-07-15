<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Vokuro\Forms\ProfilesForm;
use Vokuro\Models\Profiles;

/**
 * Vokuro\Controllers\ProfilesController
 * CRUD to manage profiles
 */
class ProfilesController extends ControllerBase
{
    /**
     * Creates a new Profile
     */
    public function createAction(): void
    {
        if ($this->request->isPost()) {
            $profile = new Profiles([
                'name' => $this->request->getPost('name', 'striptags'),
                'active' => $this->request->getPost('active'),
            ]);

            if (!$profile->save()) {
                foreach ($profile->getMessages() as $message) {
                    $this->flash->error((string)$message);
                }
            } else {
                $this->flash->success("Profile was created successfully");
            }
        }

        $this->view->setVar('form', new ProfilesForm(null));
    }

    /**
     * Deletes a Profile
     *
     * @param string $id
     */
    public function deleteAction(string $id): void
    {
        $profile = Profiles::findFirstById($id);
        if (!$profile) {
            $this->flashForward('error', 'Profile was not found', ['action' => 'index']);

            return;
        }

        if (!$profile->delete()) {
            foreach ($profile->getMessages() as $message) {
                $this->flash->error((string)$message);
            }
        } else {
            $this->flash->success("Profile was deleted");
        }

        $this->dispatcher->forward([
            'action' => 'index',
        ]);
    }

    /**
     * Edits an existing Profile
     *
     * @param string $id
     */
    public function editAction(string $id): void
    {
        $profile = Profiles::findFirstById($id);
        if (!$profile) {
            $this->flashForward('error', 'Profile was not found', ['action' => 'index']);

            return;
        }

        if ($this->request->isPost()) {
            $profile->assign([
                'name'   => $this->request->getPost('name', 'striptags'),
                'active' => $this->request->getPost('active'),
            ]);

            if (!$profile->save()) {
                foreach ($profile->getMessages() as $message) {
                    $this->flash->error((string)$message);
                }
            } else {
                $this->flash->success("Profile was updated successfully");
            }
        }

        $this->view->setVars([
            'form'    => new ProfilesForm(null, ['edit' => true]),
            'profile' => $profile,
        ]);
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction(): void
    {
        $this->persistent->conditions = null;
        $this->view->setVar('form', new ProfilesForm(null));

        $paginator = new Paginator([
            'model'      => Profiles::class,
            'parameters' => [],
            'limit'      => 10,
            'page'       => $this->request->getQuery('page', 'int', 1),
        ]);

        $this->view->setVar('page', $paginator->paginate());
    }
    /**
     * Default action. Set the private (authenticated) layout
     * (layouts/private.volt)
     */
    public function initialize(): void
    {
        $this->view->setTemplateBefore('private');
    }

    /**
     * Searches for profiles
     */
    public function searchAction(): void
    {
        if ($this->request->isPost()) {
            $query        = Criteria::fromInput($this->di, Profiles::class, $this->request->getPost());
            $searchparams = $query->getParams();
            unset($searchparams['di']);
            $this->persistent->searchParams = $searchparams;
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $profiles = Profiles::find($parameters);
        if (count($profiles) === 0) {
            $this->flashForward('notice', 'The search did not find any profiles', ['action' => 'index']);

            return;
        }

        $paginator = new Paginator(
            [
                'model'     => Profiles::class,
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $this->request->getQuery('page', 'int', 1),
            ]
        );

        $this->view->setVar('page', $paginator->paginate());
    }
}
