<?php

namespace Modules\Backend\Controllers;

class GroupPrivilegeController extends ControllerBase {
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("Permission_group_privilege");
        $this->view->breadcrumb_cat = 'Cấu hình phân quyền';
        $this->view->action = array("index"=>"Xem","edit"=>"Sửa","add"=>"Thêm","delete"=>"Xóa","status"=>"Trạng thái");
	}

    public function indexAction(){
        
        $this->tag->setTitle("Quản lý cấu hình phân quyềnh");
        $this->view->name_confirm = "Mã quyềnh";

        $options = array(
            "search"    =>  "group_id",
        	"order"		=>	"group_id asc"
        );
        $this->getDataTable($options);

        $da =   \Modules\Backend\Models\Permission_group_privilege::find();
        $role = array();
        $group = \Modules\Backend\Models\Permission_group::find();
        foreach ($da as $key => $value) {
            
            foreach ($group as $k_g => $v_g) {
                if($value->group->id == $v_g->id){
                    $role[$value->group->id][$value->privilege->controller][$value->privilege->action] = $value->privilege->action;
                }    
            }
        }
        $this->view->role = $role;
        $this->view->group_detail =  new \Modules\Backend\Controllers\GroupPrivilegeController();

    }

    public function addAction(){
        $this->tag->setTitle('Quản lý cấu hình phân quyền: Thêm mới');
        $this->view->title_action = 'Thêm mới';
        $this->assets->addCss('library/bootstrap/css/bootstrap-switch.min.css');
        $this->assets->addJs('library/bootstrap/js/bootstrap-switch.min.js');
        
        $item =  \Modules\Backend\Models\Permission_group_privilege::find();
        
        $role = array();
        $group = \Modules\Backend\Models\Permission_group::find();

        foreach ($group as $key => $value) {
            $flash = false;
            if($value->permission != "full"){
                foreach ($item as $key_item => $value_item) {
                    if($value->id == $value_item->group_id){
                        $role[$value->id][$value_item->privilege->controller][$value_item->privilege->action] = $value_item->privilege->action;
                        $flash = true;
                    } 
                }
                if($flash == false){
                    $role[$value->id] = array();
                }
            }
        }
        $this->view->role = $role;
        $privilege = \Modules\Backend\Models\Permission_privilege::find();
        $pri_active = array();
        foreach ($privilege as $key => $value) {
            if(array_key_exists($value->controller,$pri_active)){
                $pri_active[$value->controller][$value->action] = $value->action;
            } else {
                $pri_active[$value->controller][$value->action] = $value->action;
            }
        }
        $this->view->pri_active = $pri_active;
        // Xử lý cấp quyền
        if ($this->request->isPost() == true) {
            if($this->request->getPost("my") != null){
                $data = $this->request->getPost("my");
                foreach ($data as $key => $value) {
                    $item =  \Modules\Backend\Models\Permission_group_privilege::find(array(
                        "conditions"    =>  "group_id = ?1",
                        "bind"          =>  array(1 => $key)    
                    ));
                    foreach ($item as $key_item => $value_item) {
                        $value_item->delete();
                    }
                    foreach ($value as $key_controller => $value_controller) {
                        foreach ($value_controller as $key_action => $value_action) {
                            $privilege_item = \Modules\Backend\Models\Permission_privilege::find(array("conditions" => "controller =?1 AND action = ?2","bind" => array(1 => $key_controller,2 => $key_action)));     
                            if(!empty($privilege_item) && count($privilege_item) > 0){
                                foreach ($privilege_item as $key_permission => $value_permission) {
                                    $group_privilege_item = new \Modules\Backend\Models\Permission_group_privilege();
                                    $group_privilege_item->privilege_id = $value_permission->id;
                                    $group_privilege_item->group_id = $key;
                                    $group_privilege_item->status = 1;
                                    $group_privilege_item->save();
                                }
                            }
                        } 
                    }
                }    
                $this->flash->success("Thành công!");
                $this->redirect(array("action"=>"index"));
            } else {
                $this->flash->success("Thành công!");
                $this->redirect(array("action"=>"index"));
            }
        }
        $this->view->group_detail =  new \Modules\Backend\Controllers\GroupPrivilegeController();
    }
   
    public function editAction($id = null){
        $this->assets->addCss('library/bootstrap/css/bootstrap-switch.min.css');
        $this->assets->addJs('library/bootstrap/js/bootstrap-switch.min.js');
        $this->tag->setTitle("Quản lý cấu hình phân quyền: Chỉnh sửa");
        $this->view->title_action = 'Chỉnh sửa';
        
        $this->view->group_id = $id;
        $item =  \Modules\Backend\Models\Permission_group_privilege::find(array(
                "conditions"    =>  "group_id = ?1",
                "bind"          =>  array(1 => $id)    
        ));
        
        $role = array();
        $group = \Modules\Backend\Models\Permission_group::find();
        foreach ($item as $key => $value) {
            $role[$value->group->name][$value->privilege->controller][$value->privilege->action] = $value->privilege->action;
        }
        $this->view->role = $role;
        $privilege = \Modules\Backend\Models\Permission_privilege::find();
        $pri_active = array();
        foreach ($privilege as $key => $value) {
            if(array_key_exists($value->controller,$pri_active)){
                $pri_active[$value->controller][$value->action] = $value->action;
            } else {
                $pri_active[$value->controller][$value->action] = $value->action;
            }
        }
        $this->view->pri_active = $pri_active;
        // Xử lý cấp quyền
        if ($this->request->isPost() == true) {
            $item =  \Modules\Backend\Models\Permission_group_privilege::find(array(
                "conditions"    =>  "group_id = ?1",
                "bind"          =>  array(1 => $id)    
            ));
            foreach ($item as $key => $value) {
                $value->delete();
            }
            if($this->request->getPost("my") != null){
                $data[] = $this->request->getPost("my");
                foreach ($data as $key => $value) {
                    foreach ($value as $key_controller => $value_controller) {
                        foreach ($value_controller as $key_action => $value_action) {
                            $privilege_item = \Modules\Backend\Models\Permission_privilege::find(array("conditions" => "controller =?1 AND action = ?2","bind" => array(1 => $key_controller,2 => $key_action)));     
                            if(!empty($privilege_item) && count($privilege_item) > 0){
                                foreach ($privilege_item as $key_permission => $value_permission) {
                                    $group_privilege_item = new \Modules\Backend\Models\Permission_group_privilege();
                                    $group_privilege_item->privilege_id = $value_permission->id;
                                    $group_privilege_item->group_id = $id;
                                    $group_privilege_item->status = 1;
                                    $group_privilege_item->save();
                                }
                            }
                        } 
                    }
                }    
                $this->flash->success("Thành công!");
                $this->redirect(array("action"=>"index"));
            } else {
                $this->flash->success("Thành công!");
                $this->redirect(array("action"=>"index"));
            }
        }
    }

    public function deleteAction($id){
        
        $foreign = $this->foreign($id,'Permission_group','resource_id');
        if($foreign){
            if($this->delete($id)){
                $this->flash->success("Thành công!");
            } else {
                $this->flash->error("Thất bại!");
            }
        } else {
            $this->flash->error("Bạn cần xóa nhóm quyền trước khi xóa nhóm dữ liệu!");
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


    // Hàm xóa các quyền trong group-privilege
    public function deleteRoleAction($group_id = null,$privilege_controller = null){
        //lấy group_id theo group_name
        $group = \Modules\Backend\Models\Permission_group::findFirst(array(
            "conditions"    =>  "id = ?1",
            "bind"          =>  array(1 => $group_id),
            "columns"       =>  "id,name"    
        )); 
        // lấy mã privilege_id theo privilege_controller 
        $privilege =  \Modules\Backend\Models\Permission_privilege::find(array(
            "conditions"    =>  "controller = ?1",
            "bind"          =>  array(1 => $privilege_controller),
            "columns"       =>  "id,controller"    
        )); 
        if($group && $privilege){
            foreach ($privilege as $key => $value) {
                $item =  \Modules\Backend\Models\Permission_group_privilege::findFirst(array(
                    "conditions"    =>  "privilege_id = ?1 AND group_id = ?2",
                    "bind"          =>  array(1 => $value->id,2 => $group->id)    
                ));
                if(count($item) > 0 && !empty($item)){
                    $this->delete($item->id);
                } 
            }
        }
        $this->flash->success("Thành công!");
        $this->redirect(array("action"=>"index"));
    }

    /*
    *   Hàm lấy thông tin group
    *
    **/
    public function getDetailGroup($id){
        return  $group = \Modules\Backend\Models\Permission_group::findFirst(array(
            "conditions"    =>  "id = ?1",
            "bind"          =>  array(1 => $id),
            "columns"       =>  "id,name"    
        )); 
    }
}

/* End of file GroupPrivilegeController.php */
/* Location: ./apps/backend/controllers/GroupPrivilegeController.php */


