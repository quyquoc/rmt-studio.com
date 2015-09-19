<?php

namespace Modules\Frontend\Controllers;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class NewsController extends ControllerBase{
	
	protected function initialize(){
		parent::initialize();
		$this->view->setTemplateAfter('templates');		
	}

	public function indexAction($category_code = null, $code = null){

		if($category_code != null){
			if($code == null){ // hien thi danh sach tin tuc

			}else{ // hien thi tin chi tiet

				$this->setModel("News_article");
				$conditions = "code = :code: AND status = 1";
				$news		= $this->findFirst(array(
								"conditions" => $conditions, 
								"bind" => array("code" => $code)
				));

				$this->view->news = $news;
				$this->view->pick("news/detail");
			}
		}else{
			$this->response->redirect();
		}

	}
	
}

/* End of file NewsController.php */
/* Location: ./apps/frontend/controllers/NewsController.php */
