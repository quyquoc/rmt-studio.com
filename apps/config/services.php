<?php
	use Phalcon\Loader;
	use Phalcon\Mvc\View;
	use Phalcon\Mvc\Url as UrlProvider;
	use Phalcon\DI\FactoryDefault;
	use Phalcon\Flash\Session as FlashSession;
	use Phalcon\Flash\Direct as Flash;

	/**
	 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
	 */
	$di = new FactoryDefault();

	/**
	 * Register the global configuration as config
	 */
	$di->set('config', $config);

	/**
	 * Database connection is created based in the parameters defined in the configuration file
	 */
	$di->set('db', function() use ($config) {
		return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
			"host" 		=> $config->database->host,
			"username" 	=> $config->database->username,
			"password" 	=> $config->database->password,
			"dbname" 	=> $config->database->name,
			"charset" 	=> "utf8",
		));
	});

	/**
	 * Loading routes from the routes.php file
	 */
	$di->set('router', function() {
		return require __DIR__ . '/router.php';
	});

	/**
	 * The URL component is used to generate all kind of urls in the application
	 */
	$di->set('url', function() {
		$url = new \Phalcon\Mvc\Url();
		$url->setBaseUri(ROOT_URL.'/');
		return $url;
	});

	/**
	 * Start the session the first time some component request the session service
	 */
	$di->set('session', function() {
		$session = new \Phalcon\Session\Adapter\Files();
		$session->start();
		return $session;
	});

	/**
	 * Register the flash service with custom CSS classes
	 */
	$di->set('flash', function(){
	    return new FlashSession(array(
	        'error'   => 'alert alert-danger',
	        'success' => 'alert alert-success',
	        'notice'  => 'alert alert-info',
	    ));
	});

	// Dùng ở frontend
	$di->set('flasha', function(){
	    return new Flash(array(
	        'error'   => 'alert alert-danger',
	        'success' => 'alert alert-success',
	        'notice'  => 'alert alert-info',
	    ));
	});

	/**
	 * Register a component
	 */
	$di->set('plugin', function(){
		return new \Modules\Library\Plugin();
	});

	
