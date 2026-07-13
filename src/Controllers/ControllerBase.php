<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Vokuro\Plugins\Acl\Acl;
use Vokuro\Plugins\Auth\Auth;

/**
 * ControllerBase
 * This is the base controller for all controllers in the application
 *
 * @property Acl        $acl
 * @property Auth       $auth
 * @property Dispatcher $dispatcher
 * @property View       $view
 */
class ControllerBase extends Controller
{
    /**
     * Execute before the router so we can determine if this is a private
     * controller, and must be authenticated, or a public controller that is
     * open to all.
     *
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher): bool
    {
        $controllerName = $dispatcher->getControllerName();
        $actionName     = $dispatcher->getActionName();

        // Only check permissions on private controllers
        if ($this->acl->isPrivate($controllerName)) {
            // Get the current identity
            $identity = $this->auth->getIdentity();

            // If there is no identity available the user is redirected to index/index
            if (!is_array($identity)) {
                $this->flashForward('notice', 'You do not have access to this module: private', [
                    'controller' => 'index',
                    'action'     => 'index',
                ]);

                return false;
            }

            // Check if the user have permission to the current option
            if (!$this->acl->isAllowed($identity['profile'], $controllerName, $actionName)) {
                $controller = $this->acl->isAllowed($identity['profile'], $controllerName, 'index')
                    ? $controllerName
                    : 'index';

                $this->flashForward(
                    'notice',
                    'You do not have access to this module: ' . $controllerName . ':' . $actionName,
                    [
                        'controller' => $controller,
                        'action'     => 'index',
                    ]
                );

                return false;
            }
        }

        return true;
    }

    /**
     * Flashes a message of the given type and forwards to another action.
     *
     * @param string               $type    One of error, notice, success, warning.
     * @param string               $message
     * @param array<string, mixed> $forward Forward target (controller, action, params).
     *
     * @return void
     */
    protected function flashForward(string $type, string $message, array $forward): void
    {
        $this->flash->message($type, $message);
        $this->dispatcher->forward($forward);
    }
}
