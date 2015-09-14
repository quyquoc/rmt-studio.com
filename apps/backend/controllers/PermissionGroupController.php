<?php

namespace Modules\Backend\Controllers;

class PermissionGroupController extends ControllerBase {
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("Permission_group");
        $this->view->breadcrumb_cat = 'Quản lý nhóm quyền';
	}

    public function indexAction(){
    	
        $this->tag->setTitle("Quản lý nhóm quyền");
        $this->view->name_confirm = "nhóm quyền";
        $options = array(
            "search"    =>  "name",
            "foreign"   =>  array("Member", "group_id", "name"),
            "order"     =>  "name asc",
        );
        $this->getDataTable($options);
        $this->getStatusPage();     
    }

    public function addAction(){ 
    	$this->tag->setTitle('Quản lý nhóm quyền: Thêm mới');
        $this->view->title_action = 'Thêm mới';
    	$this->view->form = $this->getForm();
    	if ($this->request->isPost() == true) { 
    		$this->save($_POST,null);
    	}
    }

    public function editAction($id){
    	$this->tag->setTitle("Quản lý nhóm quyền: Chỉnh sửa");
        $this->view->title_action = 'Chỉnh sửa';
    	$model = $this->findFirstById($id);
    	$this->view->form = $this->getForm($model);
    	if ($this->request->isPost() == true) {
    		$this->save($_POST,$model);
    	}
    }

    public function deleteAction($id){
        $foreign = $this->foreign($id,'Member','group_id');
    	if($foreign){
            if($this->delete($id)){
            $this->flash->success("Thành công!");
            } else {
                $this->flash->error("Thất bại!");
            }
        } else {
            $this->flash->error("Bạn cần xóa thành viên trước khi xóa nhóm quyềnh!");
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

/* End of file PermissionGroupController.php */
/* Location: ./apps/backend/controllers/PermissionGroupController.php */


