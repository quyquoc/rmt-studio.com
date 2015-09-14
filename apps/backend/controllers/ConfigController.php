<?php

namespace Modules\Backend\Controllers;

class ConfigController extends ControllerBase{
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("Permission_config");
        $this->view->breadcrumb_cat = 'Mã quyền truy cập file';
	}

    public function indexAction(){
        
        $this->tag->setTitle("Mã quyền truy cập file");
        $this->view->name_confirm = "Mã quyền truy cập file";
        $options = array(
            "search"    =>  "name",
            "order"     =>  "name asc",
        );
        $this->getDataTable($options);
        $this->getStatusPage();     
    }

    public function addAction(){
        $this->tag->setTitle('Quản lý quyền truy cập file: Thêm mới');
        $this->view->title_action = 'Thêm mới';
        $this->view->form = $this->getForm();
        if ($this->request->isPost() == true) {
            $this->save($_POST);
        }
    }

    public function editAction($id){
        $this->tag->setTitle("Quản lý mã dữ liệu: Chỉnh sửa");
        $this->view->title_action = 'Chỉnh sửa';
        $model = $this->findFirstById($id);
        $this->view->form = $this->getForm($model);
        if ($this->request->isPost() == true) {
            $this->save($_POST,$model);
        }
    }

    public function deleteAction($id){
        
        $foreign = $this->foreign($id,'Permission_resource_config','config_id');
        if($foreign){
            if($this->delete($id)){
            $this->flash->success("Thành công!");
            } else {
                $this->flash->error("Thất bại!");
            }
        } else {
            $this->flash->error("Bạn cần xóa nhóm quyền dữ liệu trước khi xóa mã dữ liệu!");
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


    public function folderAction($role,$id){
        $item = "";
        switch ($role) {
            case 'view':
                $item = 'folder_view';
                break;
            case 'create':
                $item = 'folder_create';
                break;
            case 'reanme':
                $item = 'folder_rename';
                break;
            case 'delete':
                $item = 'folder_delete';
                break;
            default:
                break;
        }
        $model = $this->findFirstById($id);
        if($model->$item == 1){
            $status = 0;
        } else {
            $status = 1;
        }
        $parameters = array("id = :id:","bind" => array("id"=>$id));
        $data = array($item => $status); 
        $model = $this->update($parameters,$data);
        $this->flash->success("Thành công!");
        $this->redirect(array("action"=>"index"));
    }

    public function fileAction($role,$id){
        $item = "";
        switch ($role) {
            case 'view':
                $item = 'file_view';
                break;
            case 'upload':
                $item = 'file_upload';
                break;
            case 'reanme':
                $item = 'file_rename';
                break;
            case 'delete':
                $item = 'file_delete';
                break;
            default:
                break;
        }
        $model = $this->findFirstById($id);
        if($model->$item == 1){
            $status = 0;
        } else {
            $status = 1;
        }
        $parameters = array("id = :id:","bind" => array("id"=>$id));
        $data = array($item => $status); 
        $model = $this->update($parameters,$data);
        $this->flash->success("Thành công!");
        $this->redirect(array("action"=>"index"));
    }
}

/* End of file ConfigController.php */
/* Location: ./apps/backend/controllers/ConfigController.php */
