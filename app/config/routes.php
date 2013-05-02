<?php

$router = new Phalcon\Mvc\Router();

$router->add('/confirm/{code}/{email}', array(
	'controller' => 'user_control',
	'action' => 'confirmEmail'
));

$router->add('/reset-password/{code}/{email}', array(
	'controller' => 'user_control',
	'action' => 'resetPassword'
));

return $router;