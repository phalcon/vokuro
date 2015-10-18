<?php


namespace Extend;

use Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * Modules abstract class<br>
 * For more information and how to use please read on ModuleTrait.php
 */
abstract class ModulesAbstract implements ModuleDefinitionInterface
{
  use \Extend\ModulesTrait;
}