<?php

namespace Vokuro\Controllers;

use Phalcon\Tag;

/**
 * Display the terms and conditions page.
 */
class DashboardController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    /**
    * Default action. Set the public layout (layouts/public.volt)
    */
    public function indexAction()
    {
        $this->view->setVar('logged_in', is_array($this->auth->getIdentity()));
        $this->tag->setTitle('Welcome to Vökuró - Dashboard');
    }
}
