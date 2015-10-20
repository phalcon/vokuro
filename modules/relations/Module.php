<?php

namespace Modules\Relations;

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
  protected $controller_namespace = 'Modules\\Relations\\Controllers';
  protected $module_full_path = __DIR__;

  /**
   * Register a specific autoloader for the module
   */
  public function registerAutoloaders(\Phalcon\DiInterface $di = null) {
    $loader = new Loader();

    $config = include APP_DIR . '/config/config.php';

    $loader->registerNamespaces(
      array(
        'Modules\Relations\Controllers' => __DIR__ . '/controllers/',
        'Modules\Relations\Models'      => __DIR__ . '/models/',
        'Modules\Relations\Forms'       => __DIR__ . '/forms',
        'Modules\\Companies\\Models'     => $config->application->modulesDir .'/companies/models/',
        'Modules\\Invoices\\Models'     => $config->application->modulesDir .'/invoices/models/',
        'Modules\\Products\\Models'     => $config->application->modulesDir .'/products/models/',
        'Vokuro\Controllers'            => APP_DIR . '/controllers/',
      )
    );
    $loader->register();
  } /* registerAutoloaders */
}