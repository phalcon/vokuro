<?php

namespace Vokuro\Controllers;

use Phalcon\Mvc\Controller,
	Phalcon\Mvc\Dispatcher;

/**
 * ControllerBase
 *
 * This is the base controller for all controllers in the application
 */
class ControllerBase extends Controller
{
	public function beforeExecuteRoute(Dispatcher $dispatcher)
	{
		$controllerName = $dispatcher->getControllerName();

		//Only check permissions on private controllers
		if ($this->acl->isPrivate($controllerName)) {

			//Get the current identity
			$identity = $this->auth->getIdentity();

			//If there is no identity available the user is redirected to index/index
			if (!is_array($identity)) {

				$this->flash->notice('You don\'t have access to this module');

				$dispatcher->forward(array(
					'controller' => 'index',
					'action' => 'index'
				));
				return false;
			}

			//Check if the user have permission to the current option
			if (!$this->acl->isAllowed($identity['profile'], $controllerName, $dispatcher->getActionName())) {

				$this->flash->notice('You don\'t have access to this module');

				if ($this->acl->isAllowed($identity['profile'], $controllerName, 'index')) {
					$dispatcher->forward(array(
						'controller' => $controllerName,
						'action' => 'index'
					));
				} else {
					$dispatcher->forward(array(
						'controller' => 'user_control',
						'action' => 'index'
					));
				}

				return false;
			}

		}
	}
}