<?php

namespace Modules\Invoices;

use Phalcon\Loader;

/*
 *  This Module file will set up the specific namespaces for this module
 *  It extends ModulesAbstract with itself extends a ModulesTrait (new since PHP 5.4)
 *  The ModulesTrait will register a view Service (very important!) and hooks itself
 *  into the dispatcher service, to handle non-existent paths (projects/index/dontknowwhere should be handled!)
 *  Eventually it will set up specific routes for this module through a routes file
 **/
class Module extends \Extend\ModulesAbstract
{

  protected $controller_namespace = 'Modules\\Invoices\\Controllers';
  protected $module_full_path = __DIR__;

  /**
   * Register a specific autoloader for the module
   */
  public function registerAutoloaders(\Phalcon\DiInterface $di = null) // <- here it is)
  {

    $loader = new Loader();

    $config = include APP_DIR . '/config/config.php';

    $loader->registerNamespaces(
      array(
        $this->controller_namespace => __DIR__ . '/controllers/',
        'Modules\\Invoices\\Models' => __DIR__ . '/models/',
        'Modules\\Invoices\\Forms'  => __DIR__ . '/forms',
        'Modules\\Companies\\Models' => $config->application->modulesDir .'/companies/models/',
        'Modules\\Relations\\Models' => $config->application->modulesDir .'/relations/models/',
        'Modules\\Products\\Models' => $config->application->modulesDir .'/products/models/',
        'Core\\Controllers'         => APP_DIR . '/controllers/',
      )
    );

    $loader->register();
  } /* registerAutoloaders */
}