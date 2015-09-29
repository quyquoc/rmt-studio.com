<?php

namespace Modules\Frontend\Controllers;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ImageController extends ControllerBase{
	
	protected function initialize(){
		parent::initialize();
		$this->view->setTemplateAfter('templates');		
	}

	public function indexAction($group_code = null, $album_code = null, $code = null){

		$this->setModel("Image_album");
		$conditions = "group_id = :group_id: AND status = 1";
		$list_item	= $this->find(array(
				"conditions" 	=> $conditions, 
				"bind" 			=> array("group_id" => '2')
		));		
		$this->view->list_item = $list_item;

		$tbl_image = new \Modules\Frontend\Models\Image;
		$conditions = "featured = 1 AND status = 1";
		$list_image	= $tbl_image->find(array(
				"conditions" 	=> $conditions, 
				'order'			=> 'position',
		));		
		$this->view->list_image = $list_image;
	}
	
}

/* End of file ImageController.php */
/* Location: ./apps/frontend/controllers/ImageController.php */
