<?php 


error_reporting(E_ALL);

use Phalcon\Mvc\Application;

try {
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	
	include_once 'define.php';
	
	/**
	 * Read the configuration
	 */
	$config = include __DIR__ . "/../apps/config/config.php";

	/**
	 * Include services
	 */
	require __DIR__ . '/../apps/config/services.php';

	/**
	 * Handle the request
	 */
	$application = new Application();
	$application->setDI($di);

	/**
	 * Register application modules
	 */
	$application->registerModules(array(
		'frontend'	=> array(
			'className' => 'Modules\Frontend\Module',
			'path' 		=> '../apps/frontend/Module.php'
		),
		'backend'	=> array(
			'className' => 'Modules\Backend\Module',
			'path' 		=> '../apps/backend/Module.php'
		)
	));

	echo $application->handle()->getContent();


} catch (Phalcon\Exception $e) {
	echo $e->getMessage();
} 

