<?php
namespace Vokuro\Controllers;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->setTemplateBefore('public');
    }
}
