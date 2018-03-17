<?php
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Vokuro\Forms\RobotsForm;
use Vokuro\Forms\RobotsSearchForm;
use Vokuro\Models\Parts;
use Vokuro\Models\Parts2Robots;
use Vokuro\Models\Robots;

/**
 * Display the "About" page.
 */
class RobotsController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setVar('logged_in', is_array($this->auth->getIdentity()));
        $this->view->setTemplateBefore('public');
    }

    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {
        $this->persistent->conditions = null;

        $this->view->form = new RobotsSearchForm();
    }

    /**
     * Searches for users
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, Robots::class, $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];

        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $robots = Robots::find($parameters);

        if (count($robots) == 0) {
            $this->flash->notice("The search did not find any robots");

            return $this->dispatcher->forward([
                "action" => "index"
            ]);
        }

        $paginator = new Paginator([
            "data" => $robots,
            "limit" => 10,
            "page" => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }


    /**
     * Creates a Robot
     */
    public function createAction()
    {
        $years = range(1900, (int) date('Y'));
        $yearList = array_combine($years, $years);

        $options = [
            'years' => $yearList
        ];

        $form = new RobotsForm(null, $options);

        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {
                $robot = new Robots([
                    'name' => $this->request->getPost('name', 'striptags'),
                    'type' => $this->request->getPost('type', 'striptags'),
                    'year' => $yearList[$this->request->getPost('year', 'int')],
                ]);

                $robot->parts = $this->getPartsToInsert($this->request->getPost('partList', 'striptags'));

                if (! $robot->save()) {
                    $this->flash->error($robot->getMessages());
                } else {
                    $this->flash->success("Robot was created successfully");

                    $form->clear();
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Saves the user from the 'edit' action
     */
    public function editAction($id)
    {
        $robot = Robots::findFirstById($id);

        $years = range(1900, (int) date('Y'));
        $yearList = array_combine($years, $years);

        $partNames = [];

        /** @var Parts $part */
        foreach ($robot->parts as $part) {
            $partNames[] = $part->name;
        }

        $partNamesAsString = implode(',', $partNames);

        $options = [
            'years' => $yearList,
            'edit' => true,
            'partNames' => $partNamesAsString,
        ];

        if (! $robot) {
            $this->flash->error("Robot was not found");

            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }

        if ($this->request->isPost()) {
            $robot->assign([
                'name' => $this->request->getPost('name', 'striptags'),
                'type' => $this->request->getPost('type', 'striptags'),
                'year' => $yearList[$this->request->getPost('year', 'int')],
            ]);

            $form = new RobotsForm($robot, $options);

            $this->processRobotParts(
                $robot,
                $partNamesAsString,
                trim($this->request->getPost('partList', 'striptags'))
            );

            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {
                if (! $robot->save()) {
                    $this->flash->error($robot->getMessages());
                } else {

                    $this->flash->success("Robot was updated successfully");

                    $form->clear();
                }
            }
        }

        $this->view->robot = $robot;

        $this->view->form = new RobotsForm($robot, $options);
    }

    protected function processRobotParts($robot, $oldPartNames, $newPartNames)
    {
        if ($oldPartNames === $newPartNames) {
            $this->flash->notice("Robot parts were not changed.");

            return;
        }

        $oldParts = explode(',', $oldPartNames);
        $newParts = explode(',', $newPartNames);

        sort($oldParts);
        sort($newParts);

        $oldPartsIterator = new \ArrayIterator($oldParts);
        $newPartsIterator = new \ArrayIterator($newParts);

        $partsToAdd = [];
        $partsToDelete = [];

        do {
            if ($newPartsIterator->current() === $oldPartsIterator->current()) {
                // part already exists
                $newPartsIterator->next();
                $oldPartsIterator->next();
            } else if ($newPartsIterator->current() < $oldPartsIterator->current()) {
                // part needs to be added to robot
                $partsToAdd[] = $newPartsIterator->current();

                $newPartsIterator->next();
            } else {
                // old part was missed
                $partsToDelete[] = $oldPartsIterator->current();

                $oldPartsIterator->next();
            }

            if (! $newPartsIterator->current() && ! $oldPartsIterator->current()) {
                break;
            }
        } while ($newPartsIterator->valid());

        // process old parts if some were not processed
        if ($oldPartsIterator->valid()) {
            do {
                $partsToDelete[] = $oldPartsIterator->current();

                $oldPartsIterator->next();
            } while ($oldPartsIterator->valid());
        }

        try {
            // Start a transaction
            $this->db->begin();

            // delete unused relations
            foreach ($partsToDelete as $partToDelete) {
                $partInDatabase = Parts::findFirst(
                    [
                        'conditions' => 'name = ?1',
                        'bind' => [
                            1 => $partToDelete,
                        ]
                    ]
                );

                if ($partInDatabase) {
                    $partInDatabaseToDelete = Parts2Robots::findFirst(
                        [
                            'conditions' => 'robots_id = ?1 AND parts_id = ?2',
                            'bind' => [
                                1 => $robot->id,
                                2 => $partInDatabase->id,
                            ]
                        ]
                    );

                    $partInDatabaseToDelete->delete();
                }
            }

            // add new relations
            foreach ($partsToAdd as $partToAdd) {
                $partInDatabase = Parts::findFirst(
                    [
                        'conditions' => 'name = ?1',
                        'bind' => [
                            1 => $partToAdd,
                        ]
                    ]
                );

                if (! $partInDatabase) {
                    $partInDatabase = new Parts([
                        'name' => $partToAdd
                    ]);
                    $partInDatabase->save();
                }

                $partId = $partInDatabase->id;

                $part2robotInDatabase = new Parts2Robots([
                    'parts_id' => $partId,
                    'robots_id' => $robot->id,
                ]);

                $part2robotInDatabase->save();
            }

            // Commit the transaction
            $this->db->commit();
        } catch (\Exception $e) {
            // The model failed to save, so rollback the transaction
            $this->db->rollback();

            $this->flash->error('Failure with an exception.');
            $this->flash->error($e->getMessage());
        }
    }

    /**
     * Returns list of Parts for certain entity (new and already existing)
     *
     * @param  string  $partListFromInput
     *
     * @return array
     */
    protected function getPartsToInsert($partListFromInput)
    {
        $entryParts = [];

        $partsFromInput = explode(',', $partListFromInput);

        $partsFromDatabase = Parts::find();

        $partList = [];

        foreach ($partsFromDatabase as $partFromDatabase) {
            $partList[$partFromDatabase->id] = $partFromDatabase->name;
        }

        for ($i = 0; $i < count($partsFromInput); $i++) {
            $partFromInput = trim($partsFromInput[$i]);
            $found = false;
            $partId = null;
            $partName = null;

            foreach ($partsFromDatabase as $partFromDatabase) {
                if ($partFromInput === $partFromDatabase->name) {
                    $partId = $partFromDatabase->id;
                    $found = true;
                    break;
                }
            }

            if (false === $found) {
                $entryParts[] = new Parts([
                    'name' => $partFromInput,
                ]);
            } else {
                $entryParts[] = Parts::findFirst($partId);
            }
        }

        return $entryParts;
    }
}
