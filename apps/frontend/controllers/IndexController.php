<?php

namespace Modules\Frontend\Controllers;

class IndexController extends ControllerBase
{
	
	protected function initialize(){
		parent::initialize();
		$this->view->setTemplateAfter('templates');
	}

	public function indexAction(){

		$this->setModel("Image_album");
		$conditions = "group_id = :group_id: AND status = 1";
		$list_item	= $this->find(array(
				"conditions" 	=> $conditions, 
				"bind" 			=> array("group_id" => '2')
		));
		
		$this->view->list_item = $list_item;
	}
}
