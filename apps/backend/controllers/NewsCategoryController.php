<?php

namespace Modules\Backend\Controllers;

class NewsCategoryController extends ControllerBase{
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("News_category");
        $this->view->breadcrumb_cat = 'Kênh thông tin';
	}

    public function indexAction(){
    	
        $this->tag->setTitle("Kênh thông tin");
        $this->view->name_confirm = "kênh thông tin";
        $this->getDataCategory();
    }

    public function addAction(){
        $this->assets->addJs('backend/js/init_tab.js');
        $this->tag->setTitle('Kênh thông tin: Thêm mới');
        $this->view->title_action = 'Thêm mới';

        $this->view->form = $this->getForm();
        if ($this->request->isPost() == true) {
            
            $add = array(
                'code'      => $this->plugin->alias_name($_POST['title'])
            );
            $this->save($_POST, null, $add);
        }
    }

    public function editAction($id){
        $this->assets->addJs('backend/js/init_tab.js');
        $this->tag->setTitle("Kênh thông tin: Chỉnh sửa");
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
        //kiểm tra xem id này có phải là parent ko
        $parent = $this->findFirst(array("conditions" => "parents = :parents:","bind"=> array("parents"=>$id),"columns"=>"id"));
        if($parent){
            $this->flash->error("Thất bại! Kênh thông tin có mục con");
        } else { 
        	$aricle = \Modules\Backend\Models\News_Article::findFirst(array("conditions" => "category_id = :id:","bind"=> array("id"=>$id),"columns"=>"id"));
        	if(!$aricle){
        		if($this->delete($id)){
        			$this->flash->success("Thành công!");
        		} else {
        			$this->flash->error("Thất bại!");
        		}
        	} else {
        		$this->flash->error("Thất bại! Kênh thông tin có bài viết");
        	}
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

/* End of file NewsCategoryController.php */
/* Location: ./apps/backend/controllers/NewsCategoryController.php */
