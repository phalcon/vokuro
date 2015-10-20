<?php
namespace Vokuro\Plugins;

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
* This is the security plugin which controls that users only have access to the modules they're assigned to
*/
class Security extends Plugin
{
    /**
     * This action is executed before execute any action in the application
     *
     * @param Event      $event
     * @param Dispatcher $dispatcher
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        //@todo later
        if ($this->request->isPost()) {
            $tokenKey = $this->session->get('$PHALCON/CSRF/KEY$');
            $tokenValue = $this->security->getSessionToken();
            if (!$this->security->checkToken($tokenKey, $tokenValue)) {
            }
        }
    }
}
