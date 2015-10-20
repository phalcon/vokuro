<?php


namespace Vokuro;

use Phalcon\Loader;

class Module extends \Extend\ModulesAbstract
{

  protected $controller_namespace = 'Vokuro\\Controllers';
  protected $module_full_path = __DIR__;

  /**
   * Register a specific autoloader for the module
   */
  public function registerAutoloaders(\Phalcon\DiInterface $di = null) // <- here it is
  {
    $loader = new Loader();

    $loader->registerNamespaces(
      array(
        $this->controller_namespace => __DIR__ . '/controllers/',
        'Vokuro\\Models'              => __DIR__ . '/models/',
      )
    );

    $loader->register();
  } /* registerAutoloaders */
}