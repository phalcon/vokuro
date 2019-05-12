<?php
namespace Vokuro\Controllers;

/**
 * Display the privacy page.
 */
class PrivacyController extends ControllerBase
{

    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {
        $this->view->setTemplateBefore('public');
    }
}
