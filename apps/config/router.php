<?php
	/**
	 * Registering a router
	 */
	$router = new \Phalcon\Mvc\Router(false);
	$router->removeExtraSlashes(true);
	$router->setDefaultModule("frontend");
	$router->setDefaultAction("index");
	$router->setDefaultController("index"); 
	
	/* Frontend */
	$router->add('/:controller', array(
		'module' 		=> 'frontend',
		'controller' 	=> 1,
		'action' 		=> 'index',
	));
	$router->add('/:controller/:action', array(
		'module' 		=> 'frontend',
		'controller' 	=> 1,
		'action' 		=> 2,
	));
	$router->add(':controller/:action/:params', array(
		'module' 		=> 'frontend',
		'controller' 	=> 1,
		'action' 		=> 2,
		'params'		=> 3,
	));
	$router->add('/trang-chu', array(
		'module' 		=> 'frontend',
		'controller' 	=> 'index',
		'action' 		=> 'index',
	));
	$router->add('/home', array(
		'module' 		=> 'frontend',
		'controller' 	=> 'index',
		'action' 		=> 'index',
	));
	$router->add('/news/:params', array(
		'module' 		=> 	'frontend',
		'controller' 	=> 	'news',
		'action' 		=> 	'index',
		'params'		=> 	1,
	));
	$router->add('/contact', array(
		'module' 		=> 	'frontend',
		'controller' 	=> 	'contact',
		'action' 		=> 	'index',
		'params'		=> 	1,
	));
	// $router->add("/tin-tuc/{title}.{cid:[0-9]+}", array(
	// 	'module' 		=> 'frontend',
	// 	'controller' 	=> 'news',
	// 	'action' 		=> 'index'
	// ));

	/* Backend */
	$router->add("/admin", array(
		'module' 		=> 'backend',
		'controller' 	=> 'index',
		'action' 		=> 'index',
	));
	$router->add('/admin/:controller', array(
		'module' 		=> 'backend',
		'controller' 	=> 1,
		'action' 		=> 'index',
	));
	$router->add('/admin/:controller/:action', array(
		'module' 		=> 'backend',
		'controller' 	=> 1,
		'action' 		=> 2,
	));
	$router->add('/admin/:controller/:action/:params', array(
		'module' 		=> 'backend',
		'controller' 	=> 1,
		'action' 		=> 2,
		'params'		=> 3,
	));

	return $router;