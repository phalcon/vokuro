<?php
/*
 * Define custom routes. File gets included in the router service definition.
 */
$router = new Phalcon\Mvc\Router();

$router->removeExtraSlashes(true);

/*
 *  Example with all possible options:
 * $router->add('/:module/:controller/:action/:params', array(
    'module'     => 1,
    'controller' => 2,
    'action'     => 3,
    'params'     => 4
));
 *
 **/

/*
 * Let's divide the routes up in Core Routes (NameSpace Vokuro) en Modules Routes (Modules\(module name))
 */

/*
 * Core Routes (NameSpace Vokuro)
 */
$router->add('/confirm/{code}/{email}', array(
  'namespace'  => 'Vokuro\Controllers',
  'module'     => 'core',
    'controller' => 'user_control',
    'action' => 'confirmEmail'
));

$router->add('/notexist', array(
  'namespace'  => 'Vokuro\Controllers',
  'module'     => 'core',
  'controller' => 'index',
  'action'     => 'notexist'
));


$router->add('/reset-password/{code}/{email}', array(
  'namespace'  => 'Vokuro\Controllers',
  'module'     => 'core',
    'controller' => 'user_control',
    'action' => 'resetPassword'
));



$router->add('/users', array(
  'namespace'  => 'Vokuro\Controllers',
  'module'     => 'core',
  'controller' => 'users',
  'action'     => 'index'
));

$router->add('/users/:action/:params', array(
  'namespace'  => 'Vokuro\Controllers',
  'module'     => 'core',
  'controller' => 'users',
  'action'     => 1,
  'params'     => 2
));

$router->add('/profiles', array(
  'namespace'  => 'Vokuro\Controllers',
  'module'     => 'core',
  'controller' => 'profiles',
  'action'     => 'search'
));

$router->add('/profiles/:action/:params', array(
  'namespace'  => 'Vokuro\Controllers',
  'module'     => 'core',
  'controller' => 'profiles',
  'action'     => 1,
  'params'     => 2
));

$router->add('/permissions', array(
  'namespace'  => 'Vokuro\Controllers',
  'module'     => 'core',
  'controller' => 'permissions',
  'action'     => 'index'
));


$router->add('/session/:action', array(
  'namespace'  => 'Vokuro\Controllers',
  'module'     => 'core',
  'controller' => 'session',
  'action'     => 1
));

$router->add('/profiles/:action', array(
  'namespace'  => 'Vokuro\Controllers',
  'module'     => 'core',
  'controller' => 'profiles',
  'action'     => 1
));

$router->add("/login", array(
  'namespace'  => 'Vokuro\Controllers',
  'module'     => 'core',
  'controller' => 'users',
  'action'     => 'login',
));

$router->add('/', array(
  'namespace'  => 'Vokuro\Controllers',
  'module'     => 'core',
  'controller' => 'index',
  'action'     => 'index'
));


/*
 * Modules Routes (Modules\(module name))
 */
$router->add('/relations', array(
    'namespace'  => 'Modules\Relations\Controllers',
    'module'     => 'relations',
    'controller' => 'relations',
    'action'     => 'browse'
));

$router->add('/relations/:action', array(
    'namespace'  => 'Modules\Relations\Controllers',
    'module'     => 'relations',
    'controller' => 'relations',
    'action'     => 'browse'
));

$router->add('/relations/:action/:params', array(
    'namespace'  => 'Modules\Relations\Controllers',
    'module'     => 'relations',
    'controller' => 'relations',
    'action'     => 1,
    'params'     => 2
));

$router->add('/companies', array(
  'namespace'  => 'Modules\Companies\Controllers',
  'module'     => 'companies',
  'controller' => 'companies',
  'action'     => 'browse'
));

$router->add('/companies/:action', array(
  'namespace'  => 'Modules\Companies\Controllers',
  'module'     => 'companies',
  'controller' => 'companies',
  'action'     => 'browse'
));

$router->add('/companies/:action/:params', array(
  'namespace'  => 'Modules\Companies\Controllers',
  'module'     => 'companies',
  'controller' => 'companies',
  'action'     => 1,
  'params'     => 2
));

/*
 *  OK, so when certain routes get redirected to /companies/index you get a blank page.
 *  That can be solved easily by creating a controller action indexAction, but I need to fix other things first
 *  So a quick fix at the bottom(!) of all the companies routes(!) and it works
 **/
$router->add('/companies/index', array(
  'namespace'  => 'Modules\Companies\Controllers',
  'module'     => 'companies',
  'controller' => 'companies',
  'action'     => 'browse'
));

$router->add("/invoices/index", array(
  'namespace'  => 'Modules\Invoices\Controllers',
  'module'     => 'invoices',
  'controller' => 'invoices',
  'action'     => 'browse'
));

$router->add("/invoices", array(
  'namespace'  => 'Modules\Invoices\Controllers',
  'module'     => 'invoices',
  'controller' => 'invoices',
  'action'     => 'browse'
));

$router->add("/invoices/:action/:params", array(
  'namespace'  => 'Modules\Invoices\Controllers',
  'module'     => 'invoices',
  'controller' => 'invoices',
  'action'     => 1,
  'params'     => 2
));

$router->add('/products/index', array(
  'namespace'  => 'Modules\Products\Controllers',
  'module'     => 'products',
  'controller' => 'products',
  'action'     => 'browse'
));

$router->add('/products', array(
  'namespace'  => 'Modules\Products\Controllers',
  'module'     => 'products',
  'controller' => 'products',
  'action'     => 'browse'
));

$router->add("/products/:action/:params", array(
  'namespace'  => 'Modules\Products\Controllers',
  'module'     => 'products',
  'controller' => 'products',
  'action'     => 1,
  'params'     => 2
));

/*
$router->add("/products/create", array(
  'namespace'  => 'Modules\Products\Controllers',
  'module'     => 'products',
  'controller' => 'products',
  'action'     => 'create'
  ));
*/


return $router;
