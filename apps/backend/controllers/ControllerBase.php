<?php

namespace Modules\Backend\Controllers;
use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller {

	private $model; 
	private $controller;
	
	protected function initialize(){
		$this->view->setTemplateAfter('main');
		$this->setController();
        $this->view->uri = $this->getUri();  
        $this->loadJsCssBase();		
	}
	
	/**
	 * Hàm xử lý phân quyềnh người dùng
	 * @param Dispatcher $dispatcher
	 *   
	 * */
	public function beforeExecuteRoute(Dispatcher $dispatcher){	
		
		$auth = new \Modules\Library\Auth\Auth();
		if(!empty($auth->getIdentity())){
			$controllerName = $dispatcher->getControllerName();
			$actionName = $dispatcher->getActionName();
			$acl = new \Modules\Library\Acl\Acl();
			if($auth->getPermission() !== "full"){
				if (!$acl->isAllowed($auth->getPermission(), $controllerName, $actionName)) {
					if ($acl->isAllowed($auth->getPermission(), "index", "index")) {
						$this->flash->error("Từ chối truy cập");
						$dispatcher->forward(array(
								'modules' 		=> 'backend',
								'controller' 	=> 'index',
								'action' 		=> 'index'
						));
					} else {
						die();
					}
				} 
			}
		} else {
			$this->response->redirect("admin/login");
		}
	}
	
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
	 *	@return object
	 */
	protected function getModel(){

		$model = "\Modules\Backend\Models\\".$this->model;
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

		$form = "\Modules\Backend\Forms\\".$this->model;
		return new $form($model);
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
	 *	@param array $parameters [Dữ liệu truy vấn]
	 *	@return array object
	 */
	protected function find($parameters = null){
		$model = $this->getModel();
		return $model::find($parameters);
	}

	/**
	 *	Thêm dữ liệu
	 *	@param array $data [dữ liệu thêm vào]
	 *	@return boolean
	 */
	protected function create($data = array()){

		$model = $this->getModel();
		foreach ($data as $key => $value) {
			$model->$key = $value;
		}
		if($model->save()){
			return true;
		}
		return false;
	}

	/**
	 *	Cập nhật dữ liệu
	 *	@param array $parameters [Dữ liệu truy vấn]
	 *	@param array $data  [Dữ liệu update]
	 *	@return boolean 
	 */
	protected function update($parameters, $data){
		$model = $this->findFirst($parameters);
		foreach ($data as $key => $value) {
			$model->$key = $value;
		}
		if($model->save()){
			return true;
		}
		return false;
	}

	/**
	 *	Xóa dữ liệu theo id
	 *	@param string or int $id [record cần xóa]
	 *	@return boolean
	 */
	protected function delete($id){

		$model = $this->getModel();
		$record = $model::findFirstById($id);
		if(!empty($record)){
			if($record->delete()){
				return true;
			}
		}
		return false;
	}

	/**
	 *	Create object và edit object
	 *	@param $_POST $post [Dữ liệu là POST]
	 *	@param array $data [Dữ liệu cần thêm ko nằm trong form]
	 *	@return boolean
	 */
	protected function save($post, $model = null, $data = null, $redirect = true){

		// model = null là thêm mới , model khác null là sửa
		if($model === null){
			$model = $this->getModel();
		}
		
		$form = $this->getForm();
		$form->bind($post, $model); 
		// data != null thêm những trường không có ở trong form
		if($data !== null && is_array($data)){
			foreach ($data as $key => $value) {
				$model->$key = $value;
			}
		}
		
		if ($form->isValid($post, $model)) {
			if($model->save()){
				if($redirect){
					$this->flash->success("Thành công!");
					$this->redirect(array("action"=>"index"));
					$this->view->disable();
				} else {
					return true;
				}
			} else {
				$this->flash->error("Thất bại!");
			}	
		} else {
			$error = array();
			foreach ($form->getMessages(true) as $attribute => $messages) {
			    $error[$attribute] = $attribute;
			}
			$this->view->error = $error;
			$this->flash->error("Thất bại!");
		}
		return false;
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
 	 *	Kiểm tra có tồn tại khóa ngoại không
 	 *	@param $primary_key string [Khóa chính ở bảng A]
 	 *	@param $model object [Model join tới]
 	 *	@param $column string [Tên trường join tới]
 	 *	@return boolean
	 */
	protected function foreign($primary_key = null,$model = null,$column = null){

		if(!empty($primary_key) && !empty($model)){
			$model = "\Modules\Backend\Models\\".$model;
			$object = new $model();
			$query = array(
				"conditions" => "{$column} = :key:",
				"bind"		 =>	array("key"=>$primary_key)
			);
			$record = $object::findFirst($query);
			if(!empty($record)){ 
				return false;
			}
			return true;
		}
		return true;
	}

	/**
	 *	Xóa nhiều dòng dữ liệu
	 */
	protected function delete_multiple($foreign = null){

     	$id = $this->request->getPost("checkbox");
        if(count($id)>0){
        	$id = implode(',',$id);
            $conditions = "id IN({$id})";
            $model = $this->getModel();
			$record = $model::find($conditions);
			if(!empty($foreign)){ // Xóa có khóa ngoại
				$name_error = ""; 
				if(isset($foreign[0],$foreign[1],$foreign[2])){
					foreach ($record as $obj) {
						$fo = $this->foreign($obj->id,$foreign[0],$foreign[1]);
						if($fo){
							$obj->delete();	
						} else {
							$name_error .= '"'.$obj->$foreign[2].'" ';
						}
					}
					if(!empty($name_error)){
						$this->flash->error("Các mục: ".$name_error." chứa thành phần con. Không thể xóa!");
					} else {
						$this->flash->success("Thành công!");
					}
				} else {
					$this->flash->error("Đang xử lý!");
				}
			} else { // Xóa không cần kiểm tra khóa ngoại
				foreach ($record as $obj) {
					$obj->delete();
				}
				$this->flash->success("Thành công!");
			}
        }   
	}

	/**
	 *	Thay đổi trạng thái nhiều dòng dữ liệu
	 *	@param int $status [0,1]
	 */
	protected function status_multiple($status){

		$id = $this->request->getPost("checkbox");
		if(count($id)>0){
        	$id = implode(',',$id);
            $conditions = "id IN({$id})";
            $model = $this->getModel();
			$record = $model::find($conditions);
			foreach ($record as $obj) {
				$obj->status = $status;
				$obj->save();
			}
			$this->flash->success("Thành công!");
        }   
	}

	/**
	 *	Update nhiều dòng dữ liệu
	 *	@param array $column [Tên cột muốn update]
	 */
	protected function update_multiple($column = null){ 
		$order = $this->request->getPost("possition");
        if(count($order)>0){
        	foreach ($order as $key => $value) {
        		$model = $this->findFirstById($key);
				foreach ($column as $c_key => $c_value) {
					$model->$c_value = $value;
					$model->save();
				}
        	}
        	$this->flash->success("Thành công!");
        }
        return false;
	}

	/**
	 *	Set page vào session để trả về trang đứng trước đó
	 */
	protected function setSessionPage($column_search = null,&$session){
		$controller = $this->getController();
		$uri = array();
		if(isset($_GET['page']) && !empty($_GET['page'])){
			$uri['page'] = (int) $_GET['page'];
		} 
		if(isset($_GET['limit']) && !empty($_GET['limit'])){
			$uri['limit'] = (int) $_GET['limit'];
		} 
		
		if(isset($_GET[$column_search]) && !empty($_GET[$column_search])){
			$uri['search'] = array('column'=>$column_search,'data'=>$_GET[$column_search]);
		} 
		if(count($uri) > 0){
			$this->session->set("uri_{$controller}",$uri);
		}
		// Lấy giá trị tìm kiếm để hiện lại ô input
		$uri_data = $this->session->get("uri_{$controller}");
		$this->view->value_search = $uri_data['search']['data'];
		$session = $uri_data;
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
        	$constant = new \Modules\Library\Constant();
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
        $paginator_link = new \Modules\Library\Paginator($this->view->data,$this->getController());
        $this->view->link = $paginator_link->getLink($this->view->column_search);

        // STT
        $this->view->stt = $limit * $currentPage - ($limit-1);
	
        // Limit record
        $html = new \Modules\Library\Html();
        $this->view->data_limit = $html->getLimitRecord($search,$session['limit']);

        // System
        $system = new \Modules\Library\System($options["order"]);
        $this->view->system = $system;

        //Plugin
        $plugin = new \Modules\Library\Plugin();
        $this->view->plugin = $plugin;
	}

	/**
	 *	Lấy dữ liệu của category
	 */
	protected function getDataCategory(){
		$model = $this->getModel();
		$result = $model::find();
		
		$system = new \Modules\Library\System();
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
					if(count($record)>0){
						$fail = "";
						foreach ($record as $key => $value) {
							$parent = $this->findFirst(array("conditions" => "parents = :parents:","bind"=> array("parents"=>$value->id),"columns"=>"id,title"));
							if(!$parent){
								$aricle = \Modules\Backend\Models\News_article::findFirst(array("conditions" => "category_id = :id:","bind"=> array("id"=>$value->id),"columns"=>"id"));
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
        //Plugin
        $plugin = new \Modules\Library\Plugin();
        $this->view->plugin = $plugin;
	}

	/**
	 *	Hàm  chuyển đến trạng thái của controller trước đó
	 */
	protected function getStatusPage(){
		if($this->getPage() != null){
            if(count($_GET) == 1){
                $this->redirect(array("action"=>"index"));
            }
        }   
	}

	/**
	 *	Load js,css chung của page
	 */
	protected function loadJsCssBase(){
		//load Css
		$this->assets->addCss('library/confirm/css/jquery.confirm.css');
		//load Js
        $this->assets->addJs('backend/js/init_index.js')
                     ->addJs('library/confirm/js/jquery.confirm.js')
                     ->addJs('backend/js/install_confirm.js')
        			 ->addJs('library/ckfinder/ckfinder.js')
                     ->addJs('library/ckeditor/ckeditor.js')
                     ->addJs('backend/js/install_ckeditor.js')
                     ->addJs('backend/js/install_filebrowse.js');
	}

	/**
	 *	Hàm lấy menu item của từng menu
	 *	@param $menu_id
	 */
	protected function getMenuItem($menu_id){
		$model = $this->getModel();
		$result = $model::findByMenu_id($menu_id);
		$system = new \Modules\Library\System();
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
					if(count($record)>0){
						$fail = "";
						foreach ($record as $key => $value) {
							$parent = $this->findFirst(array("conditions" => "parents = :parents:","bind"=> array("parents"=>$value->id),"columns"=>"id,title"));
							if(!$parent){
								$aricle = \Modules\Backend\Models\News_article::findFirst(array("conditions" => "category_id = :id:","bind"=> array("id"=>$value->id),"columns"=>"id"));
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
        //Plugin
        $plugin = new \Modules\Library\Plugin();
        $this->view->plugin = $plugin;
	}

	/**
	 *	Hàm get columns filter
	 */
	public function columnsfilter($columns = null){
		$ui = "";
		if(!empty($columns) && is_array($columns)){
			foreach ($columns as $key => $value) { 
				if(!empty($value) && is_array($value)){
					$name = "";
					foreach ($value as $k => $v) {
						$type = "";
						if($k == 'name'){
							$name = $v;
						}
						if($k == 'searchoptions'){
							foreach ($v as $ks => $vs) {
								if($vs == 'text'){
									$type = '<input type="text" name="'.$name.'" />';
								} else if($vs == 'select'){
									
								}
							}
						}

					}
					$ui .= '<td>'.$type.'</td>';
				} else {
					$ui .= '<td></td>';
				}
			}
		}
		$this->view->ui = $ui;
	}
}

/* End of file ControllerBase.php */
/* Location: ./apps/backend/controllers/ControllerBase.php */
