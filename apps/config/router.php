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
	$router->add('/tin-tuc/:params', array(
		'module' 		=> 	'frontend',
		'controller' 	=> 	'news',
		'action' 		=> 	'index',
		'params'		=> 	1,
	));
	$router->add('/shop/:params', array(
		'module' 		=> 	'frontend',
		'controller' 	=> 	'shop',
		'action' 		=> 	'index',
		'params'		=> 	1,
	));
	$router->add('/shop/gio-hang', array(
		'module' 		=> 	'frontend',
		'controller' 	=> 	'shop',
		'action' 		=> 	'viewcart',
	));
	$router->add('/shop/mua-hang/:params', array(
		'module' 		=> 	'frontend',
		'controller' 	=> 	'shop',
		'action' 		=> 	'additem',
		'params'		=> 	1,
	));
	$router->add('/shop/dat-hang', array(
		'module' 		=> 	'frontend',
		'controller' 	=> 	'shop',
		'action' 		=> 	'order',
	));
	$router->add('/purchase/:params', array(
		'module' 		=> 	'frontend',
		'controller' 	=> 	'purchase',
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