<?php
namespace Vokuro\Controllers;

/**
 * Display the "About" page.
 */
class AboutController extends BaseController
{

    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {
        $this->view->setTemplateBefore('public');
    }
}
