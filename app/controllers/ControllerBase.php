<?php
namespace Vokuro\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo;
use Phalcon\Logger\Adapter\File as Logger;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

/**
 * Class ControllerBase
 * This is the base controller for all controllers in the application
 */
class ControllerBase extends Controller
{
    /**
     * Display item in a page
     */
    const ITEM_IN_PAGE = 30;
    /**
     * @var string
     */
    public $currentOrder = null;


    /**
     * Execute before the router so we can determine if this is a private controller, and must be authenticated, or a
     * public controller that is open to all.
     *
     * @param Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $controllerName = $dispatcher->getControllerName();

        // Only check permissions on private controllers
        if ($this->acl->isPrivate($controllerName)) {

            // Get the current identity
            $identity = $this->auth->getIdentity();

            // If there is no identity available the user is redirected to index/index
            if (!is_array($identity)) {

                $this->flash->notice('You don\'t have access to this module: private');

                $dispatcher->forward(array(
                    'controller' => 'index',
                    'action' => 'index'
                ));
                return false;
            }
// Check if the user has permission to the current option
            $actionName = $dispatcher->getActionName();
            if (!$this->acl->isAllowed($identity['profile'], $controllerName, $actionName)) {

                $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

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

    /**
     * Create a QueryBuilder paginator, show 15 rows by page starting from $page
     *
     * @param array $model The model need to retrieve and someoption {code} $mode = [ 'name'      => 'Phanbook\Models\Users' 'orderBy'   => 'username' 'currentOrder'=> 'users'// mean adding class for menu ] {/code}
     * {code}
     *      $mode = [
     *          'name'      => 'Phanbook\Models\Users'
     *          'orderBy'   => 'username'
     *          'currentOrder'=> 'users'// mean adding class for menu
     *      ]
     * {/code}
     * @param int   $page  Current page to show
     *
     * @return array the conatainer object...
     */
    public function paginatorQueryBuilder($model, $page)
    {
        $builder = $this->modelsManager->createBuilder()
            ->from($model['name'])
            ->orderBy($model['orderBy']);
        //Create a Model paginator, show 15 rows by page starting from $page
        $paginator   = (new PaginatorQueryBuilder(
            [
                'builder'  => $builder,
                'limit'     => self::ITEM_IN_PAGE,
                'page'      => $page
            ]
        ))->getPaginate();
        $this->view->setVars(
            [
            'currentOrder'  => $model['currentOrder'],
            'object'        => $paginator->items,
            'canonical'     => '',
            'totalPages'    => $paginator->total_pages,
            'currentPage'   => $page,
            ]
        );
    }

    public function indexRedirect()
    {
        return $this->response->redirect();
    }

    public function currentRedirect()
    {
        if ($url = $this->session->get('urlCurrent')) {
            $this->session->remove('urlCurrent');
            return $this->response->redirect($url);
        }
        return $this->response->redirect($this->request->getHTTPReferer(), true);
    }

    /**
     * The function sending log for nginx or apache, it will to analytic later
     * @return mixed
     */
    public function saveLogger($e)
    {
        //error_log($e);
        $logger = new Logger(ROOT_DIR . 'apps/logs/error.log');
        if (is_object($e)) {
            //d($e);
            $logger->error($e[0]->getMessage());
        }
        if (is_array($e)) {
            foreach ($e as $message) {
                d($e);
            }
        }
        if (is_string($e)) {
            $logger->error($e);
        }

        return $this->indexRedirect();
    }
}
