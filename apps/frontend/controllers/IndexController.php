<?php

namespace Modules\Frontend\Controllers;

class IndexController extends ControllerBase
{
	
	protected function initialize(){
		parent::initialize();
		$this->view->setTemplateAfter('templates');
	}

	public function indexAction(){
		
	}
}
