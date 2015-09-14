<?php

namespace Modules\Backend\Controllers;

class MemberController extends ControllerBase {
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("Member");
        $this->view->breadcrumb_cat = 'Quản lý thành viên';
	}

    public function indexAction(){	
    	
        $this->tag->setTitle("Quản lý thành viên");
        $this->view->name_confirm = "thành viên";

        $options = array(
            "search"    =>  "username",
        	"order"		=>	"username asc"
        );
        $this->getDataTable($options);
        $this->getStatusPage();
    }

    public function addAction(){
        $this->tag->setTitle('Quản lý thành viên: Thêm mới');
        $this->view->title_action = 'Thêm mới';
    	$this->view->form = $this->getForm();
    	if ($this->request->isPost() == true) {
            $hash = new \Modules\Library\Hash();
    		$salt = $hash->random();
    		$data = array(
    			'created'	=>	date("Y-m-d"),
    			'salt'		=>	$salt,
    		);
            $_POST['password'] = $hash->create(md5($_POST['password']),$salt);
    		if($this->save($_POST,null,$data) == true){
                $this->tag->setDefault('username', '');
                $this->tag->setDefault('password', '');
                $this->tag->setDefault('email', '');
            }
    	}
    }

    public function editAction($id){
        $this->tag->setTitle('Quản lý thành viên: Chỉnh sửa');
        $this->view->title_action = 'Thêm mới';
    	$model = $this->findFirstById($id);
    	$this->view->form = $this->getForm($model);
    	if ($this->request->isPost() == true) {
    		
    		if($_POST['password'] != $model->password){
    			$hash = new \Modules\Library\Hash();
    			$_POST['password'] = $hash->create(md5($_POST['password']),$model->salt);
    		}
    		
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

/* End of file MemberController.php */
/* Location: ./apps/backend/controllers/MemberController.php */
