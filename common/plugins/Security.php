<?php
/**
 * Phanbook : Delightfully simple forum software
 *
 * Licensed under The GNU License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link    http://phanbook.com Phanbook Project
 * @since   1.0.0
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */
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
            //$tokenValue = $this->request->getPost('csrf', null, 'Shit!!');
            $tokenValue = $this->security->getSessionToken();
            /*var_dump($tokenKey);
            var_dump($tokenValue);
            var_dump($this->security->checkToken());
            var_dump($this->security->checkToken($tokenKey, $tokenValue));
            d($_SESSION, false);
            d($tokenValue);*/
            if (!$this->security->checkToken($tokenKey, $tokenValue)) {
                //throw new \Exception('Token error!');
                //return false;
            }
        }
    }
}
