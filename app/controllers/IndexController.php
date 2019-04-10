<?php

namespace Vokuro\Controllers;

use Phalcon\Tag;

/**
 * Display the default index page.
 */
class IndexController extends ControllerBase
{
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function initialize()
    {
        $this->view->setTemplateBefore('public');
    }

    public function indexAction()
    {
        $this->view->setVar('logged_in', is_array($this->auth->getIdentity()));
        $this->tag->setTitle('Welcome to Vökuró - Home');
    }
}
