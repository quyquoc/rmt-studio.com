<?php

namespace Modules\Frontend;

class Module
{

	public function registerAutoloaders(){

		$loader = new \Phalcon\Loader();

		$loader->registerNamespaces(array(
			'Modules\Frontend\Controllers' 	=> __DIR__ . '/controllers/',
			'Modules\Frontend\Models' 		=> __DIR__ . '/models/',
			'Modules\Frontend\Forms' 		=> __DIR__ . '/forms/',
			'Modules\Frontend\Elements' 	=> __DIR__ . '/elements/',
			'Modules\Library' 				=> __DIR__ . '/../library/',
		));

		$loader->register();
	}

	public function registerServices($di){

		$di['dispatcher'] = function() {
			$dispatcher = new \Phalcon\Mvc\Dispatcher();
			$dispatcher->setDefaultNamespace("Modules\Frontend\Controllers");
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

		/**
		* Register a component
		*/
		$di->set('menu', function(){
			return new \Modules\Frontend\Elements\Menu();
		});
		$di->set('element', function(){
			return new \Modules\Frontend\Elements\Element();
		});
	}

}