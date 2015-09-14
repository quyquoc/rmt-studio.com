<?php

namespace Modules\Backend\Controllers;

class ImageAlbumController extends ControllerBase{
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("Image_album");
        $this->view->breadcrumb_cat = 'Album ảnh';
	}

    public function indexAction(){
    	
        $this->tag->setTitle("Album ảnh");
        $this->view->name_confirm = "Album ảnh";
        $options = array(
            "search"    =>  "title",
            "order"     =>  "title asc",
        );
        $this->getDataTable($options);
        $this->getStatusPage();
    }

    public function addAction(){
        $this->assets->addJs('backend/js/init_tab.js')
                     ->addJs('backend/js/install_filebrowse_image.js');
        $this->assets->addCss('library/bootstrap/css/bootstrap-combined.min.css');

        $this->tag->setTitle('Album ảnh: Thêm mới');
        $this->view->title_action = 'Thêm mới';
        $this->view->form = $this->getForm();
        if ($this->request->isPost() == true) {

            $system = new \Modules\Library\System();

            $code = $_POST['title'];
            $system->getCode($code, "Image_album");
            $add = array(
                    'code'      =>  $code,
                    'attr_image'=>  $_POST['attr_image'],
            );

            $this->save($_POST, null, $add);
        }
    }

    public function editAction($id){
        $this->assets->addJs('backend/js/init_tab.js')
                     ->addJs('backend/js/install_filebrowse_image.js');
        $this->assets->addCss('library/bootstrap/css/bootstrap-combined.min.css');

        $this->tag->setTitle("Album ảnh: Chỉnh sửa");
        $this->view->title_action = 'Chỉnh sửa';
        $model = $this->findFirstById($id);
        
        $this->view->form = $this->getForm($model);
        
        // load ảnh attr_image của sản phẩm
        $arr_image =  explode(",", $model->attr_image);
        if(!empty($arr_image)){
            $list_image = array();
            foreach ($arr_image as $key => $value) {
                if(!empty($value)){
                    $list_image[] = $value;
                }
            }
            $this->view->image_value = implode(",",$list_image);
            $this->view->list_image = $list_image;
        } // End load thuộc tính sản phẩm;

        if ($this->request->isPost() == true) {
            $update = array(
                    'attr_image'=>  $_POST['attr_image'],
                    'updated'   =>  date('Y-m-d H:i:s'),
            );

            $this->save($_POST, $model,$update);
        }
    }
    
    public function deleteAction($id){
        
        $foreign = $this->foreign($id,'Image','album_id');
        if($foreign){
            if($this->delete($id)){
                $this->flash->success("Thành công!");
            } else {
                $this->flash->error("Thất bại!");
            }
        } else {
            $this->flash->error("Bạn cần xóa ảnh trước khi xóa album!");
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

/* End of file ImageAlbumController.php */
/* Location: ./apps/backend/controllers/ImageAlbumController.php */
