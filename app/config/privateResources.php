<?php

use Phalcon\Config;
use Phalcon\Logger;

return new Config([
  'privateResources' => [
    'dashboard'      => ['index'],
    'users'          => ['index','create','edit','delete','authorization','changePassword'],
    'roles'          => ['index','create','edit','delete','editPermission']
  ]
]);
