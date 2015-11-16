<?php

namespace Modules\Backend;

use \Phalcon\Mvc\View\Engine\Volt as VoltEngine;

class Module
{

	public function registerAutoloaders(){

		$loader = new \Phalcon\Loader();

		$loader->registerNamespaces(array(
			'Modules\Backend\Controllers' 	=> __DIR__ . '/controllers/',
			'Modules\Backend\Models' 		=> __DIR__ . '/models/',
			'Modules\Backend\Forms' 		=> __DIR__ . '/forms/',
			'Modules\Library' 				=> __DIR__ . '/../library/',
		));

		$loader->register();
	}

	public function registerServices($di){

		$di['dispatcher'] = function() {
			$dispatcher = new \Phalcon\Mvc\Dispatcher();
			$dispatcher->setDefaultNamespace("Modules\Backend\Controllers");
			return $dispatcher;
		};

		/**
		 * Setting up the view component
		 */
		$di['view'] = function() {
			$view = new \Phalcon\Mvc\View();
			$view->setViewsDir(__DIR__ . '/views/');
			return $view;
		};
	}

}