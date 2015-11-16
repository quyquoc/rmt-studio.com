<?php

namespace Modules\Backend\Controllers;

class NewsArticleController extends ControllerBase{
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("News_article");
        $this->view->breadcrumb_cat = 'Bài viết';
	}

    public function indexAction(){	
    	
        $this->tag->setTitle("Bài viết");
        $this->view->name_confirm = "bài viết";
        $options = array(
            "search"    =>  "title",
            "order"     =>  "created desc"
        );
        $this->getDataTable($options);
        $this->getStatusPage();
    }

    public function addAction(){

        $this->assets->addJs('backend/js/init_tab.js');
        $this->tag->setTitle('Bài viết: Thêm mới');
        $this->view->title_action = 'Thêm mới';

        $this->view->form = $this->getForm();

        if ($this->request->isPost() == true) {

            $code = $_POST['title'];
            $this->plugin->create_code($code, "News_article");

            $_POST['image'] = str_replace(PUBLIC_URL, '', $_POST['image']);

            $identity       = $this->session->get('auth-identity');

        	$add = array(
                'code'      =>  $code,
    			'hits'		=>	'0',
    			'created'	=>	date('Y-m-d H:i:s'),
    			'updated'	=>	date('Y-m-d H:i:s'),
                'creator_id'=>  $identity['id'],
        	);

            $this->save($_POST, null, $add);
        }           
    }

    public function editAction($id){

        $this->assets->addJs('backend/js/init_tab.js');
        $this->tag->setTitle("Bài viết: Chỉnh sửa");
        $this->view->title_action = 'Chỉnh sửa';

        $model = $this->findFirstById($id);       
        $this->view->form = $this->getForm($model);

        if ($this->request->isPost() == true) {

            $this->plugin->create_code($_POST['code'], "News_article", $id);

            $_POST['image'] = str_replace(PUBLIC_URL, '', $_POST['image']);

            $identity = $this->session->get('auth-identity');
            
            $update = array(
                'updated'   =>  date('Y-m-d H:i:s'),
                'editor_id' =>  $identity['id']
            );

            $this->save($_POST, $model, $update);
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
        $this->flash->success("Thành công!");
        $this->redirect(array("action"=>"index"));
    }
}

/* End of file NewsArticleController.php */
/* Location: ./apps/backend/controllers/NewsArticleController.php */
