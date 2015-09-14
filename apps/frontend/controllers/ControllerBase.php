<?php

namespace Modules\Frontend\Controllers;
use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ControllerBase extends Controller {

	private $model; 
	private $controller;
	private $form;
	
	protected function initialize(){		
	}
	
	/**
	 *	@param string $controller
	 */
	protected function setController(){
	
		$this->controller = $this->router->getControllerName();
	}

	/**
	 *	@return string $controller
	 */
	protected function getController(){

		return $this->controller;
	}

	/**
	 *	@param string $model
	 */
	protected function setModel($model){

		$this->model = $model;
	}

	/**
	 *	@param string $form
	 */
	protected function setForm($form){

		$this->form = $form;
	}

	/**
	 *	@return object
	 */
	protected function getModel(){

		$model = "\Modules\Frontend\Models\\".$this->model;
		return new $model();
	}

	/**
	 *	@return đường dẫn hiện tại
	 */
	protected function getRewriteUri(){

		return $this->router->getRewriteUri();
	}
	
	/**  
	 *	Hàm lấy từ admin tới controlelr 
	 */
	protected  function getUri(){

		return "admin/".$this->getController()."/";
	}
	
	/**
	 *	@param obj $model
	 *	@return form
	 */
	protected function getForm($model = null){

		$form = "\Modules\Frontend\Forms\\".$this->form;
		return new $form($model);
	}
		
	/**
	 *	@param array $parameters [Dữ liệu truy vấn]
	 *	@return array object
	 */
	protected function find($parameters = null){
		$model = $this->getModel();
		return $model::find($parameters);
	}

	/**
	 *	@param array $parameters [Dữ liệu truy vấn]
	 *	@return object: 1 record
	 */
	protected function findFirst($parameters = null){

		$model = $this->getModel();
		return $model::findFirst($parameters);
	}

	/**
	 *	@param integer $id [ID]
	 *	@return object: 1 record
	 */
	protected function findFirstById($id){
		$model = $this->getModel();
		return $model::findFirstById($id);
	}

	/**
	 *	Chuyển trang
	 *	@param array $uri [controller/action]
	 */
	protected function redirect($uri){
		$str = "admin/";
		if(isset($uri['controller']) && !empty($uri['controller'])){
			$str .= $uri['controller'];
		} else {
			$str .= $this->getController();
		}
		if(isset($uri['action']) && !empty($uri['action'])){
			if($uri['action'] == "index"){
				$str .= "/".$uri['action'].$this->getPage();
			} else {
				$str .= "/".$uri['action'];
			}
		} else {
			$str .= "/index";
		}
    	$this->response->redirect($str);
	}

	/**
	 *	Get số page uri
	 */
	protected function getPage(){
		$controller = $this->getController();
		$uri_data = $this->session->get("uri_{$controller}");
		$url = "";
		if(count($uri_data) > 0){
			
			//$char = count($_GET) == 1 ? "?":"&";
			$char = count($uri_data) == 1 ? "?":"&";
			if(isset($uri_data['page'])){
				$url .= "{$char}page=".$uri_data['page'];
			}
			if(isset($uri_data['limit'])){
				$url .= "{$char}limit=".$uri_data['limit'];
			}
			if(isset($uri_data['search'])){
				$url .= "{$char}{$uri_data['search']['column']}=".$uri_data['search']['data'];
			}
		}
		if(!empty($url)){
			return $url;
		}
		return null;
	}
	
	/**
	 *  Xóa sesion page 
	 */
	protected function clearSessionPage(){
		$controller = $this->getController();
		$this->session->remove("uri_{$controller}");
	}
	
	/**
	 *	Hàm lấy dữ liệu hiện ra index
	 *	@param $options array
	 *	
	 */
	protected function getDataTable($options = null){

		// set page bằng session
		$this->setSessionPage($options['search'], $session);
		$conditions = '';
		$q_order = '';

		// Tìm kiếm
        if(isset($_GET[$options['search']])){
        	$value = $_GET[$options['search']];
        	$conditions .= "{$options['search']} LIKE :value:";
        	$search = "&{$options['search']}=".$_GET[$options['search']];
        	$conditions = "{$options['search']} LIKE :value:";
        	$search = "&{$options['search']}=".$_GET[$options['search']];

        } else {
        	$search = null;
        	$value = null;
        }

		// dữ liệu để sort
		if(isset($_GET['column'], $_GET['order'])){
			$column 	= $_GET['column'];
			$order 		= $_GET['order'];
			$q_order 	= "{$column} {$order}";	
		} else {

			if(isset($options['order'])){
				$q_order = $options['order'];	
			} else {
				$q_order = "id asc";
			}
			$order = null;
		}
        $this->view->page 	= isset($_GET['page']) ? "?page={$_GET['page']}":"";
        $this->view->order 	= isset($_GET['order']) && $_GET['order'] == "asc"  ? "&order=desc{$search}":"&order=asc{$search}";
        // end
        $currentPage = isset($_GET['page']) ? (int) $_GET["page"] : 1;
        // truyền cột cần tìm kiếm ra view
        $this->view->column_search = $options['search'];
        $query =  array(
			    'conditions' 	=> $conditions,
			    'bind' 			=> array('value' => '%'.$value.'%'),
			    'order' 		=> $q_order
		); 
        $data = $this->find($query);

        if(isset($options['limit'])){
        	$limit = $options['limit'];
        } else {
        	$constant = new \Modules\Frontend\Library\Constant();
 			$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : (int)$constant::LIMIT_PAGE;
        }
       
        $paginator = new PaginatorModel(
		    array(
		        "data"  => $data,
		        "limit" => $limit,
		        "page"  => $currentPage
		    )
		);

        $this->view->data =  $paginator->getPaginate();

        // Xử lý submit tùy chọn
        if($this->request->isPost()){
            // xóa nhiều
            if($this->request->getPost("delete")){ 
                $this->delete_multiple($options['foreign']);
            }
            // kích hoạt nhiều
            if($this->request->getPost("active")){
                $this->status_multiple(1);
            }
            // đóng kích hoạt nhiều
            if($this->request->getPost("no_active")){
                $this->status_multiple(0);
            }
            
            // sắp xếp nhiều
            if($this->request->getPost("order")){
                $this->update_multiple(array("position"));
            }
            $this->view->disable();
            $this->redirect(array("action"=>"index")); 
        }		
        
        // Lấy link phân trang (dạng html)
        $paginator_link = new \Modules\Frontend\Library\Paginator($this->view->data,$this->getController());
        $this->view->link = $paginator_link->getLink($this->view->column_search);

        // STT
        $this->view->stt = $limit * $currentPage - ($limit-1);
	
        // Limit record
        $html = new \Modules\Frontend\Library\Html();
        $this->view->data_limit = $html->getLimitRecord($search,$session['limit']);

        // System
        $system = new \Modules\Frontend\Library\System($options["order"]);
        $this->view->system = $system;
	}

	/**
	 *	Lấy dữ liệu của category
	 */
	protected function getDataCategory(){
		$model = $this->getModel();
		$result = $model::find();
		
		$system = new \Modules\Frontend\Library\System();
		$result = $system->convert_object_to_array($result);
		$data = null;
		$system->recursive($result,0,1,$data);
		$this->view->data = $data;

		// Xử lý submit tùy chọn
        if($this->request->isPost()){
            // xóa nhiều
            if($this->request->getPost("delete")){ 
                $id = $this->request->getPost("checkbox");
		        if(count($id)>0){
		        	$id = implode(',',$id);
		            $conditions = "id IN({$id})";
		            $model = $this->getModel();
					$record = $model::find(array("conditions"=>$conditions,"colums"=>"id,title"));
					if($record){
						$fail = "";
						foreach ($record as $key => $value) {
							$parent = $this->findFirst(array("conditions" => "parents = :parents:","bind"=> array("parents"=>$value->id),"columns"=>"id,title"));
							if(!$parent){
								$aricle = \Modules\Frontend\Models\News_Article::findFirst(array("conditions" => "category_id = :id:","bind"=> array("id"=>$value->id),"columns"=>"id"));
								if(!$aricle){
									$value->delete();
								} else {
									$fail .= $value->title.",";
								}
							} else {
								$fail .= $value->title.",";
							}
						}
						if(!empty($fail)){
							$this->flash->error("Xóa thất bại: ".$fail);	
						}
						
						$this->view->disable();
					}
		        }   
            }
            // kích hoạt nhiều
            if($this->request->getPost("active")){
                $this->status_multiple(1);
            }
            // đóng kích hoạt nhiều
            if($this->request->getPost("no_active")){
                $this->status_multiple(0);
            }
            
            // sắp xếp nhiều
            if($this->request->getPost("order")){
                $this->update_multiple(array("position"));
            }
            $this->view->disable();
            $this->redirect(array("action"=>"index"));
        }
	}

	/**
	 *	Load js,css chung của page
	 */
	protected function loadJsCssBase(){
		//load Css
		$this->assets->addCss('Frontend/library/confirm/css/jquery.confirm.css');
		//load Js
        $this->assets->addJs('Frontend/js/init_index.js')
                     ->addJs('Frontend/library/confirm/js/jquery.confirm.js')
                     ->addJs('Frontend/js/install_confirm.js');
	}
}