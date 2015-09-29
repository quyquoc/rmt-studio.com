<?php

namespace Modules\Frontend\Controllers;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class NewsController extends ControllerBase{
	
	protected function initialize(){
		parent::initialize();
		$this->view->setTemplateAfter('templates');		
	}

	public function indexAction($category_code = null, $code = null){

		$tbl_article	= new \Modules\Frontend\Models\News_article();

		if(isset($code) && !empty($code)){// hien thi chi tiet

			$conditions = 'code = :code: and status = 1';
			$item 		= $tbl_article->findFirst(array(
				'conditions'	=> $conditions,
				'bind'			=> array('code'=>$code),
			));				
			$this->view->item 	= $item;
			$this->view->pick("news/detail");			
		}else{ // hien thi danh sach

			if($category_code == null){// tin tuc chung
				$conditions = 'status = 1';
				$list_item 	= $tbl_article->find(array(
					'conditions'	=> $conditions,
					'order'			=> 'published DESC',
					"limit"			=>	7,
				));
			}else{// tin theo kenh thong tin

				//begin: lay category_id
				$category 	= new \Modules\Frontend\Models\News_category();
				$conditions = 'code = :code: and status = 1';
				$category 	= $category->findFirst(array(
					'conditions'	=> $conditions,
					'bind'			=> array('code'=>$category_code),
				));
				// end: lay category_id

				if($category){
					$conditions = 'category_id = :category_id: and status = 1';
					$list_item 			= $tbl_article->find(array(
						'conditions'	=> $conditions,
						'bind'			=> array('category_id'=>$category->id),
						'order'			=> 'published DESC',
						"limit"			=>	7,
					));
					$this->view->category = $category;
				}else{
					$this->response->redirect('tin-tuc');
				}
			}

			$currentPage 	= isset($_GET['page']) ? (int) $_GET["page"] : 1;
			$paginator 		= new PaginatorModel(
		    	array(
		        	"data"  => $list_item,
		        	"limit" => 7,
		        	"page"  => $currentPage
		    	)
			);

    		$list_item = $paginator->getPaginate(); 
    		$this->view->list_item 	= $list_item->items; 
    		$option = array(
    			"controller" 		=> "tin-tuc",
    			"menu_code"			=> 'tin-tuc',
    			'style_paginator' 	=> 0
    		);
    		$this->view->paginator 	= $this->plugin->getPaginator($option, $list_item);
		}
	}
	
}

/* End of file NewsController.php */
/* Location: ./apps/frontend/controllers/NewsController.php */
