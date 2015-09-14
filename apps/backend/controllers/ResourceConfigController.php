<?php

namespace Modules\Backend\Controllers;

class ResourceConfigController extends ControllerBase{
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("Permission_resource_config");
        $this->view->breadcrumb_cat = 'Quyền truy cập file';
	}

    public function indexAction(){
        
        $this->tag->setTitle("Quyền truy cập file");
        $this->view->name_confirm = "Quyền truy cập file";
        $options = array(
            "search"    =>  "resource_id",
            "order"     =>  "resource_id asc",
        );
        $this->getDataTable($options);
        $this->getStatusPage();     
    }

    public function addAction(){
        $this->tag->setTitle('Quản lý quềnh truy cập file: Thêm mới');
        $this->view->title_action = 'Thêm mới';
        $this->view->form = $this->getForm();
        if ($this->request->isPost() == true) {
            $this->save($_POST);
        }
    }

    public function editAction($id){
        $this->tag->setTitle("Quản lý nhóm dữ liệu: Chỉnh sửa");
        $this->view->title_action = 'Chỉnh sửa';
        $model = $this->findFirstById($id);
        $this->view->form = $this->getForm($model);
        if ($this->request->isPost() == true) {
            $this->save($_POST,$model);
        }
    }

    public function deleteAction($id){
        
        if($this->delete($id)){
        $this->flash->success("Thành công!");
        } else {
            $this->flash->error("Thất bại!");
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

/* End of file NewsArticleController.php */
/* Location: ./apps/backend/controllers/ResourceController.php */
