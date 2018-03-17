<?php
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Vokuro\Forms\RobotsForm;
use Vokuro\Models\Parts;

/**
 * Display the "About" page.
 */
class PartsController extends ControllerBase
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

    }

    /**
     * Searches for users
     */
    public function allAction()
    {
        $parts = Parts::find();

        $partList = [];

        foreach ($parts as $part) {
            $partList[] = $part->name;
        }

        $this->setJsonResponse();

        return $partList;
    }
}
