<?php

namespace Modules\Frontend\Controllers;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class NewsController extends ControllerBase{
	
	protected function initialize(){
		parent::initialize();
		$this->view->setTemplateAfter('templates');		
	}

	public function indexAction($menu_code = null, $article = null){
		$plugin = new \Modules\Library\Plugin;
		$this->view->plugin = $plugin;
		
		if($menu_code != null && $menu_code == 'tin-tuc' && !isset($_GET['page'])){
			$this->response->redirect('tin-tuc');
		}
		if($menu_code == null){
			$menu_code = "tin-tuc";
		}

		// kiểm tra code menu có hợp lệ hay không
		
		$this->setModel("Menu_item");
		$conditions = "code = :code: AND status = 1";
		$menu_item	= $this->findFirst(array(
				"conditions" => $conditions, 
				"bind" => array("code" => $menu_code)
		));
		if(!$menu_item){
			$this->response->redirect('tin-tuc');
		}
		
		$this->view->menu_code = $menu_code; 
		$params_c = $plugin->getItemParam($menu_item->params);
		$this->view->params_c = $params_c;
		$this->view->menu_item = $menu_item;
		
		if(isset($params_c) && !empty($params_c) && isset($params_c['show'])){
		
			$conditions 	= "parents = :id: AND status = 1"; 
			$menu_list		= $this->find(array("conditions" => $conditions, "bind" => array("id" => $menu_item->id)));
			$this->view->menu_list = $menu_list;
			if(count($menu_list) > 0){
				$data = array();
				$plugin->getMenuItemChildren($menu_list[0]->parents,0,'params',$data);	
				if(count($data) > 0){
					$category_id = array(); 
					foreach ($data as $key => $value) {
						if(!empty($value)){
							$params_a = $plugin->getItemParam($value);
							if(isset($params_a['category'])){
								$i = explode(",",$params_a['category']);
								foreach ($i as $ki => $vi) {
									$category_id[] = $vi;
								}
							}
						}
					}
					$category_id = implode(',', $category_id);
					$params_c['category'] = $category_id;
					$this->getListNews($params_c,$menu_code);
				}
			} 
		}
			
		if($article != null){
			$article = explode("-", $article);
			$article = $article[count($article) - 1]; 
			$item = explode("a", $article);
			if(isset($item[1])){ 
				$article_id = $item[1];
				$this->setModel("News_article");
				$conditions = "id = :id: AND status = 1";
				$news 	= $this->findFirst(array("conditions" => $conditions,"bind"=>array("id"=>$article_id)));
				if(!$news){
					$this->response->redirect('tin-tuc');
				}
				$this->view->news = $news;
			}
			$this->view->pick("news/detail");
		}
	}

	// Hàm lấy danh sách tin tức 
	private function getListNews($params_c,$menu_code){ 
		
		if(isset($params_c['category'])){
			$category_id 	= $params_c['category'];	
		} else {
			$category_id 	= 0;
		} 
		$news 		= new \Modules\Frontend\Models\News_article();

		if($params_c['show_paginator'] == 0 && isset($params_c['items']) && !empty($params_c['items']) ){ 
			$limit = $params_c['items'];
		} else { 
			$limit = null;
		}
		
		$conditions	= "category_id IN({$category_id}) AND status = 1";	 
		$list_news 	= $news::find(array(
						"conditions" 	=> 	$conditions, 
						"order"			=>	"published desc",
						//"columns"		=> 	"id,title,description,image,link,params,published",	
						"limit"			=>	$limit,
		));

		if($params_c['show_paginator'] == 1){ //Có phân trang
			
			$currentPage = isset($_GET['page']) ? (int) $_GET["page"] : 1;
			$paginator = new PaginatorModel(
		    	array(
		        	"data"  => $list_news,
		        	"limit" => $params_c['items'],
		        	"page"  => $currentPage
		    	)
			);
			$plugin = new \Modules\Library\Plugin;
    		$list_news =  $paginator->getPaginate(); 
    		$this->view->list_news = $list_news->items; 
    		$option = array("controller" => "tin-tuc","menu_code" => $menu_code,'style_paginator' => $params_c['style_paginator']);
    		$this->view->paginator = $plugin->getPaginator($option,$list_news);

		} else { 
			$this->view->list_news = $list_news;
		}
	}
	
}

/* End of file NewsController.php */
/* Location: ./apps/frontend/controllers/NewsController.php */
