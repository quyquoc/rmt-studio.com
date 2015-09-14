<?php

namespace Modules\Backend\Controllers;

class ImageGroupController extends ControllerBase{
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("Image_group");
        $this->view->breadcrumb_cat = 'Chủ đề ảnh';
	}

    public function indexAction(){
    	
        $this->tag->setTitle("Chủ đề ảnh");
        $this->view->name_confirm = "Chủ đề ảnh";
        $options = array(
            "search"    =>  "title",
            "order"     =>  "title asc",
        );
        $this->getDataTable($options);
        $this->getStatusPage();
    }

    public function addAction(){
        $this->tag->setTitle('Chủ đề ảnh: Thêm mới');
        $this->view->title_action = 'Thêm mới';
        $this->view->form = $this->getForm();
        if ($this->request->isPost() == true) {

            $system = new \Modules\Library\System();

            $code = $_POST['title'];
            $system->getCode($code, "Image_group");
            $add = array(
                'code'=>$code
            );

            $this->save($_POST, null, $add);
        }
    }

    public function editAction($id){
        $this->tag->setTitle("Chủ đề ảnh: Chỉnh sửa");
        $this->view->title_action = 'Chỉnh sửa';
        $model = $this->findFirstById($id);
        
        $this->view->form = $this->getForm($model);
        if ($this->request->isPost() == true) {
            $update = array(
                    'updated'   =>  date('Y-m-d H:i:s'),
            );

            $this->save($_POST, $model,$update);
        }
    }
    
    public function deleteAction($id){
        
        $foreign = $this->foreign($id,'Image_album','group_id');
        if($foreign){
            if($this->delete($id)){
                $this->flash->success("Thành công!");
            } else {
                $this->flash->error("Thất bại!");
            }
        } else {
            $this->flash->error("Bạn cần xóa album trước khi xóa nhóm!");
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
}

/* End of file ImageGroupController.php */
/* Location: ./apps/backend/controllers/ImageGroupController.php */
