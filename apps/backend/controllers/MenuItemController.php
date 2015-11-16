<?php
namespace Modules\Backend\Controllers;

class MenuItemController extends ControllerBase{
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("Menu_item");
        $this->view->breadcrumb_cat = 'Menu Item';
	}

    public function indexAction($menu_id = null){

        $this->tag->setTitle("Kênh menu");
        $this->view->name_confirm   = "menu";
        $this->view->menu_id        = $menu_id;
        $this->getMenuItem($menu_id);
        // $this->getDataCategory();
    }

    public function addAction($menu_id = null){

        $this->assets->addJs('backend/js/init_tab.js');
        $this->assets->addJs('library/ckfinder/ckfinder.js')
                     ->addJs('backend/js/install_filebrowse.js');
        $this->tag->setTitle('Menu: Thêm mới');
        $this->view->title_action = 'Thêm mới';

        $form = new \Modules\Backend\Forms\Menu_item(null, $menu_id);
        $this->view->form = $form;
        if ($this->request->isPost() == true) {

            $_POST['code'] = $this->plugin->alias_name($_POST['name']);
            $this->save($_POST, null, null, false);

            //xu ly rieng vi phai hien thi menu item theo menu
            $this->redirect(array("action"=>"index/".$menu_id));
        }

        $this->view->menu_id = $menu_id;
    }

    public function editAction($id){
        $this->assets->addCss('library/fancybox/jquery.fancybox.css');
        $this->assets->addJs('library/ckfinder/ckfinder.js')
                     ->addJs('backend/js/install_filebrowse.js')
                     ->addJs('backend/js/init.js')
                     ->addJs('library/fancybox/jquery.fancybox.js');
        $this->tag->setTitle("Menu: Chỉnh sửa");
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
            $this->flash->error("Thất bại! Kênh menu có mục con");
        } else { 
        	$aricle = \Modules\Backend\Models\News_article::findFirst(array("conditions" => "category_id = :id:","bind"=> array("id"=>$id),"columns"=>"id"));
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

    public function showAction($id){
        // $this->loadJsCssBase();
        
        $this->assets->addCss('library/fancybox/jquery.fancybox.css')
                     ->addJs('library/fancybox/jquery.fancybox.js');
        
        $this->tag->setTitle("Kênh menu");
        $this->view->name_confirm   = "menu";
        $this->view->menu_id        = $id;
        $this->getMenuItem($id);
    }
}

/* End of file NewsCategoryController.php */
/* Location: ./apps/backend/controllers/NewsCategoryController.php */
