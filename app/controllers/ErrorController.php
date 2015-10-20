<?php
namespace Vokuro\Controllers;

/**
 * Display the default index page.
 */
class ErrorController extends BaseController
{
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {
        $this->view->setVar('logged_in', is_array($this->auth->getIdentity()));
        $this->view->setTemplateBefore('error');
    }

    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function show404Action()
    {
        //$this->view->setTemplateBefore('error');
    }

}
