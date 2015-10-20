<?php
namespace Vokuro\Controllers;

/**
 * Display the terms and conditions page.
 */
class TermsController extends BaseController
{

    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {
        $this->view->setTemplateBefore('public');
    }
}
