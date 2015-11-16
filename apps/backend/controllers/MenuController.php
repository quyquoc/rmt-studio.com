<?php

namespace Modules\Backend\Controllers;

class MenuController extends ControllerBase {
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("Menu");
        $this->view->breadcrumb_cat = 'Quản lý menu';
	}

    public function indexAction(){
    
        $this->tag->setTitle("Quản lý menu");
        $this->view->name_confirm = "menu";
        $options = array(
            "search"    =>  "name",
            "order"     =>  "name asc",
        );
        $this->getDataTable($options);
        $this->getStatusPage();
    }

    public function addAction(){

    	$this->tag->setTitle('Quản lý menu: Thêm mới');
        $this->view->title_action = 'Thêm mới';
        
    	$this->view->form = $this->getForm();

    	if ($this->request->isPost() == true) {

            $code = $_POST['name'];
            $this->plugin->create_code($code, "Menu");

            $_POST['image'] = str_replace(PUBLIC_URL, '', $_POST['image']);

            $add = array(
                'code'      =>  $code
            );

            $this->save($_POST, null, $add);
    	}
    }

    public function editAction($id){

    	$this->tag->setTitle("Quản lý menu: Chỉnh sửa");
        $this->view->title_action = 'Chỉnh sửa';

    	$model = $this->findFirstById($id);        
    	$this->view->form = $this->getForm($model);

    	if ($this->request->isPost() == true) {

            $this->plugin->create_code($_POST['code'], "Menu", $id);

            $_POST['image'] = str_replace(PUBLIC_URL, '', $_POST['image']);

            $this->save($_POST, $model);
    	}
    }

    public function deleteAction($id){
        
        $foreign = $this->foreign($id,'Menu_item','menu_id');
    	if($foreign){
            if($this->delete($id)){
            $this->flash->success("Thành công!");
            } else {
                $this->flash->error("Thất bại!");
            }
        } else {
            $this->flash->error("Bạn cần xóa menu thành phần trước khi xóa menu cha!");
        }

        $this->redirect(array("action"=>"index"));
    }

    public function statusAction($id){
        $model = $this->findFirstById($id);
        if($model->status == 1){
            $status = 0;
        } else {
            $status = 1;
        }
        $parameters = array("id = :id:","bind" => array("id"=>$id));
        $data = array("status" => $status); 
        $model = $this->update($parameters,$data);
        $this->flash->success("Thành công!");
        $this->redirect(array("action"=>"index"));
    }
	
    public function clearAction(){
    	$this->clearSessionPage();
    	$this->redirect(array("action"=>"index"));
    }

}

/* End of file MenuController.php */
/* Location: ./apps/backend/controllers/MenuController.php */
