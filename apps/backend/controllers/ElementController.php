<?php

namespace Modules\Backend\Controllers;

class ElementController extends ControllerBase {
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("Element");
        $this->view->breadcrumb_cat = 'Quản lý chức năng';
	}

    public function indexAction(){
        
        $this->assets->addCss('library/fancybox/jquery.fancybox.css')
                     ->addJs('library/fancybox/jquery.fancybox.js');
 
        $this->tag->setTitle("Quản lý chức năng");
        $this->view->name_confirm = "chức năng";
        $options = array(
            "search"    =>  "name",
            "foreign"   =>  array("Element_type", "type", "name"),
            "order"     =>  "name asc",
        );
        $this->getDataTable($options);
        $this->getStatusPage();     
    }

    public function addAction(){
        $this->setModel("Element_type");
        $this->view->setTemplateAfter('tpl_popup');
        $list_item = $this->find(
            array(
                // "conditions" => "parents = :parents:",
                // "bind"=> array("parents"=>$value->id),
                'order' => 'name ASC',
            )
        );
        $this->view->list_item = $list_item;
    	// $this->tag->setTitle('Quản lý chức năng: Thêm mới');
        // $this->view->title_action = 'Thêm mới';
    	// $this->view->form = $this->getForm();
    	// if ($this->request->isPost() == true) {
    	// 	$this->save($_POST,null,array('created'=>date('Y-m-d')));
    	// }
    }

    public function editAction($id){
    	// $this->tag->setTitle("Quản lý chức năng: Chỉnh sửa");
        // $this->view->title_action = 'Chỉnh sửa';
    	// $model = $this->findFirstById($id);
    	// $this->view->form = $this->getForm($model);
    	// if ($this->request->isPost() == true) {
    	// 	$this->save($_POST,$model);
    	// 	$this->view->disable();
    	// 	$this->redirect(array("action"=>"index"));
    	// }
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

/* End of file ElementController.php */
/* Location: ./apps/backend/controllers/ElementController.php */
