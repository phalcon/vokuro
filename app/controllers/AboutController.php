<?php
namespace Vokuro\Controllers;

class AboutController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->setTemplateBefore('public');
    }
}
