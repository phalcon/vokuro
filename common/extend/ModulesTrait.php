<?php


namespace Extend;

use Phalcon\Loader,
  Phalcon\Mvc\Dispatcher,
  Phalcon\Mvc\View,
  Phalcon\Mvc\View\Engine\Volt,
  Plugins;

/**
 * Modules trait.<br><br>
 * Use this file to manage register services in one place.<br>
 * To use this trait, set your module like Phalcon Module.php but extend \Extend\ModulesAbstract<br>
 * Setup $controller_namespace property for Module class to your default controller namespace<br>
 * Set $module_full_path property to __DIR__ for easy to manage.<br>
 */
trait ModulesTrait
{
  protected $default_controller_namespace = 'Vokuro\\Controllers';
  protected $default_module_full_path = APP_DIR;

  /**
   * Register specific services for the module
   */
  public function registerServices(\Phalcon\DiInterface $di = null) // <- here it is
  {
    /*
     *  Let's set up some variables, we can use them to show which module type we are in. Core or Module?
     *  get module caller class to retrieve data
     **/
    $module_caller_name = get_called_class();

    $module_caller = new $module_caller_name;
    if (property_exists($module_caller, 'controller_namespace')) {
      $default_namespace = $module_caller->controller_namespace;
    } else {
      $default_namespace = $this->default_controller_namespace;
    }

    /*
     *  Unfortunately, on Windows we need to replace the backslashes with normal slashes
     **/
    if (property_exists($module_caller, 'module_full_path')) {
      $module_full_path = str_replace('\\', '/', $module_caller->module_full_path);
    } else {
      $module_full_path = str_replace('\\', '/', $this->default_module_full_path);
    }

    unset($module_caller_name);

    $config = include APP_DIR . '/config/config.php';

    /*
     *  Registering the view component
     *  Figure out which ModuleType we are in and then set up the Layout path according to that viewType
     *  Modules are in a totally different directory (and namespace) than the core modules.
     **/
    $di->set('view', function () use ($config, $module_full_path) {
      $ModuleType = '';
      $view = new View();

      /*
       *  When needed : layouts dir. Problem is that it overrides my index, which i don't want
       **/
      if (strstr($module_full_path, 'modules')) {
        $ModuleType = 'module';
        $view->setViewsDir($module_full_path . '/views/');
        $view->setLayoutsDir("../../../app/views/layouts/");
      } else {
        $ModuleType = 'core';
        $view->setLayoutsDir("layouts/");
      }



      $this->default_module_full_path = str_replace('\\', '/', $this->default_module_full_path);
      /*
       *  If everything is just wrong, resort back to the main main index view.
       **/
      if ($module_full_path != $this->default_module_full_path) {
        $view->setMainView('../../../app/views/index');
      }

      /*
       *  Register the Volt template engine in the view. Also register the .php and .phtml extensions.
       *  Try to use as much volt as you can
       **/
      $view->registerEngines(array(
        '.volt'  => function ($view, $di) use ($config) {

          $volt = new Volt($view, $di);

          if (!file_exists($config->application->cacheDir . 'volt/')) {
            mkdir($config->application->cacheDir . 'volt/');
          }

          $volt->setOptions(array(
            'compiledPath'      => $config->application->cacheDir . 'volt/',
            'compiledSeparator' => '_'
          ));
          $compiler = $volt->getCompiler();
          $compiler->addFunction('is_a', 'is_a');
          $compiler->addFunction('sprintf', 'sprintf');
          $compiler->addFunction('strtotime', 'strtotime');

          return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php',
        '.php'   => 'Phalcon\Mvc\View\Engine\Php'
      ));

      return $view;
    }); /* End View Service */

    /*
     *  Registering a dispatcher
     *  This should also take care of the non-found views and some exceptions
     **/
    $di->set('dispatcher', function () use ($di, $default_namespace) {

      $eventsManager = $di->getShared('eventsManager');

      $dispatcher = new Dispatcher;

      /*
       *  Adding the notfound plugin
       **/
      $eventsManager->attach('dispatch:beforeException', new \Vokuro\Plugins\ExceptionsPlugin);

      $dispatcher->setEventsManager($eventsManager);
      $dispatcher->setDefaultNamespace($default_namespace);

      return $dispatcher;
    }); /* End dispatcher Registration */


    unset($default_namespace, $module_full_path);
  } /* End registerServices */
}