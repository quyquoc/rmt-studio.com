<?php

namespace Modules\Backend\Controllers;

class DepartmentController extends ControllerBase {
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("Member_department");
        $this->view->breadcrumb_cat = 'Quản lý bộ phận';
	}

    public function indexAction(){
    	
        $this->tag->setTitle("Quản lý bộ phận");
        $this->view->name_confirm = "bộ phận";
        $options = array(
            "search"    =>  "name",
            "foreign"   =>  array("Member", "department_id", "name"),
            "order"     =>  "name asc",
        );
        $this->getDataTable($options);
        $this->getStatusPage();     
    }

    public function addAction(){
    	$this->tag->setTitle('Quản lý bộ phận: Thêm mới');
        $this->view->title_action = 'Thêm mới';
    	$this->view->form = $this->getForm();
    	if ($this->request->isPost() == true) {
    		$this->save($_POST, null, array('created'=>date('Y-m-d')));
    	}
    }

    public function editAction($id){
    	$this->tag->setTitle("Quản lý bộ phận: Chỉnh sửa");
        $this->view->title_action = 'Chỉnh sửa';
    	$model = $this->findFirstById($id);
    	$this->view->form = $this->getForm($model);
    	if ($this->request->isPost() == true) {
    		$this->save($_POST,$model);
    	}
    }

    public function deleteAction($id){
        
        $foreign = $this->foreign($id,'Member','department_id');
    	if($foreign){
            if($this->delete($id)){
            $this->flash->success("Thành công!");
            } else {
                $this->flash->error("Thất bại!");
            }
        } else {
            $this->flash->error("Bạn cần xóa thành viên trước khi xóa bộ phận!");
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

/* End of file DepartmentController.php */
/* Location: ./apps/backend/controllers/DepartmentController.php */
