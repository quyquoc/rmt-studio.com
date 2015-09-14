<?php
namespace Modules\Backend\Controllers;

class MenuItemController extends ControllerBase{
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("Menu_item");
        $this->view->breadcrumb_cat = 'Menu Item';
	}

    public function indexAction(){

        $this->tag->setTitle("Kênh menu");
        $this->view->name_confirm = "menu";
        $this->getDataCategory(); 
    }

    public function addAction($menu_id = null){
        $this->setModel("Menu_type");
        $this->view->setTemplateAfter('tpl_popup');
        $list_item = $this->find(
            array(
                // "conditions" => "parents = :parents:",
                // "bind"=> array("parents"=>$value->id),
                'order' => 'name ASC',
            )
        );
        $this->view->list_item  = $list_item;
        $this->view->menu_id    = $menu_id;

        // $this->assets->addJs('library/ckfinder/ckfinder.js')
        //              ->addJs('backend/js/install_filebrowse.js');
        // $this->tag->setTitle('Kênh thông tin: Thêm mới');
        // $this->view->title_action = 'Thêm mới';
        // $this->view->form = $this->getForm();
        // if ($this->request->isPost() == true) {

        //     // thong tin cau hinh
        //     foreach ($_POST['params'] as $key => $value) {
        //         if($key == 'category'){
        //             $id = implode(',',$_POST['params']['category']);
        //             $value = $id;
        //         }
        //         $params .= $key.'='.$value.';';
        //     }

        //     $system = new \Modules\library\System();
        //     $code = $_POST['name'];
        //     $system->getCode($code,"Menu_item");

        //     $add = array('params' => $params,'code'=>$code);
        //     $this->save($_POST, null, $add);
        // }
    }

    public function editAction($id){
        $this->assets->addCss('library/fancybox/jquery.fancybox.css');
        $this->assets->addJs('library/ckfinder/ckfinder.js')
                     ->addJs('backend/js/install_filebrowse.js')
                     ->addJs('backend/js/init.js')
                     ->addJs('library/fancybox/jquery.fancybox.js');
        $this->tag->setTitle("Kênh menu: Chỉnh sửa");
        $this->view->title_action = 'Chỉnh sửa';
        $model = $this->findFirstById($id);
        
        $this->view->form = $this->getForm($model);
        if ($this->request->isPost() == true) {
            // thong tin cau hinh
            foreach ($_POST['params'] as $key => $value) {
                if($key == 'category'){
                    $var = implode(',',$_POST['params']['category']);
                    $value = $var;
                }
                $params .= $key.'='.$value.';';
            }

            $system = new \Modules\library\System();
            $code = $_POST['name'];
            $system->getCode($code,"Menu_item",$id);

            $add = array('params' => $params);
            $this->save($_POST,$model,$add);
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
