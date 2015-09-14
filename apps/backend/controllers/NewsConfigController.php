<?php

namespace Modules\Backend\Controllers;

class NewsConfigController extends ControllerBase{
   
	protected function initialize(){
        parent::initialize();
        $this->setModel("Element");
        $this->view->breadcrumb_cat = 'Cấu hình chức năng';
	}

    public function indexAction(){
        $this->response->redirect('admin/element/index');
    }

    public function addElementAction($type = null){
        $this->assets->addJs('backend/js/init_tab.js');
        $this->tag->setTitle('Cấu hình chức năng: Thêm mới');
        $this->view->title_action   = 'Thêm mới';
        $this->view->type           = $type;

        $category               = \Modules\Backend\Models\News_category::find();
        $system                 = new \Modules\Library\System();
        $category               = $system->convert_object_to_array($category);
        $data                   = null;
        $system->recursive($category, 0, 1, $data);
        $category               = $system->getListTreeCategory($data, 'title');
        $this->view->category   = $category;

        if ($this->request->isPost() == true) {
            // thong tin cau hinh
            foreach ($_POST['params'] as $key => $value) {
                if($key == 'category'){
                    $params .= $key.'='.implode(',', $value).';';
                }else{
                    $params .= $key.'='.$value.';';
                }
            }
        	$add = array(
                    'params'    => $params,
        	);
            $this->save($_POST, null, $add);
        }

        $this->view->pick("news-config/add-element");
    }

    public function editElementAction($id = null){
        $this->assets->addJs('backend/js/init_tab.js');
        $this->tag->setTitle("Cấu hình chức năng: Chỉnh sửa");
        $this->view->title_action = 'Chỉnh sửa';

        $this->view->form = $this->getForm();

        // Truyen ra view Kenh thong tin
        $category               = \Modules\Backend\Models\News_category::find();
        $system                 = new \Modules\Library\System();
        $category               = $system->convert_object_to_array($category);
        $data                   = null;
        $system->recursive($category, 0, 1, $data);
        $category               = $system->getListTreeCategory($data, 'title');
        $this->view->category   = $category;

        $element = \Modules\Backend\Models\Element::findFirstById($id);
        $this->view->element = $element;

        $params = $this->plugin->getItemParam($element->params);
        $this->view->params = $params;

        if ($this->request->isPost() == true) {
            // thong tin cau hinh
            $params = '';
            foreach ($_POST['params'] as $key => $value) {
                if($key == 'category'){
                    $params .= $key.'='.implode(',', $value).';';
                }else{
                    $params .= $key.'='.$value.';';
                }
            }
            $update = array(
                    'params'    => $params,
            );

            $this->save($_POST, $element, $update);
        }

        $this->view->pick("news-config/edit-element");
    }

    public function addMenuAction($type = null, $menu_id = null){
        $this->assets->addJs('backend/js/init_tab.js');
        $this->tag->setTitle('Cấu hình menu: Thêm mới');
        $this->view->title_action   = 'Thêm mới';
        $this->view->type           = $type;
        $this->view->menu_id        = $menu_id;

        $system     = new \Modules\Library\System();

        // Thuoc menu
        $menu = \Modules\Backend\Models\Menu::findFirstById($menu_id);
        $this->view->menu = $menu;
    
        // Menu_item        
        $parents              = \Modules\Backend\Models\Menu_item::findByMenu_id($menu_id);
        $parents              = $system->convert_object_to_array($parents);
        $data                 = null;
        $system->recursive($parents, 0, 1, $data);
        $parents              = $system->getListTreeCategory($data, 'name');
        $this->view->parents  = $parents;

        // Kenh thong tin
        $category               = \Modules\Backend\Models\News_category::find();
        $category               = $system->convert_object_to_array($category);
        $data                   = null;
        $system->recursive($category, 0, 1, $data);
        $category               = $system->getListTreeCategory($data, 'title');
        $this->view->category   = $category;

        if ($this->request->isPost()) {

            $this->setModel("Menu_item");
            // thong tin cau hinh
            $params = '';
            foreach ($_POST['params'] as $key => $value) {
                if($key == 'category'){
                    $params .= $key.'='.implode(',', $value).';';
                }else{
                    $params .= $key.'='.$value.';';
                }
            }

            $system = new \Modules\library\System();
            $code = $_POST['name'];
            $system->getCode($code, "Menu_item");

            $data = array(
                    'name'      => $this->request->getPost('name'),
                    'code'      => $code,
                    'image'     => $this->request->getPost('image'),
                    'type'      => 'news.'.$type,
                    'target'    => $this->request->getPost('target'),
                    'params'    => $params,
                    'parents'   => $this->request->getPost('parents'),
                    'menu_id'   => $this->request->getPost('menu_id'),
                    'status'    => $this->request->getPost('status'),
            );

            $this->create($data);
            $this->response->redirect("admin/menu-item/show/{$menu_id}");
        }

        $this->view->pick("news-config/add-menu");
    }

    public function editMenuAction($id = null){
        $this->assets->addJs('backend/js/init_tab.js');
        $this->tag->setTitle('Cấu hình menu: Chỉnh sửa');
        $this->view->title_action = 'Chỉnh sửa';

        // Lay thong tin menu_item
        $menu_item = \Modules\Backend\Models\Menu_item::findFirstById($id);
        $this->view->menu_item  = $menu_item;

        $params = $this->plugin->getItemParam($menu_item->params);
        $this->view->params     = $params;

        $system     = new \Modules\Library\System();

        // Thuoc menu
        $menu = \Modules\Backend\Models\Menu::findFirstById($menu_item->menu_id);
        $this->view->menu = $menu;
    
        // Menu_item        
        $parents              = \Modules\Backend\Models\Menu_item::findByMenu_id($menu_item->menu_id);
        $parents              = $system->convert_object_to_array($parents);
        $data                 = null;
        $system->recursive($parents, 0, 1, $data);
        $parents              = $system->getListTreeCategory($data, 'name');
        $this->view->parents  = $parents;

        // Kenh thong tin
        $category               = \Modules\Backend\Models\News_category::find();
        $category               = $system->convert_object_to_array($category);
        $data                   = null;
        $system->recursive($category, 0, 1, $data);
        $category               = $system->getListTreeCategory($data, 'title');
        $this->view->category   = $category;

        if ($this->request->isPost() == true) {
            // thong tin cau hinh
            $params = '';
            foreach ($_POST['params'] as $key => $value) {
                if($key == 'category'){
                    $params .= $key.'='.implode(',', $value).';';
                }else{
                    $params .= $key.'='.$value.';';
                }
            }

            $parameters = "id = {$id}";
            $data = array(
                    'name'      => $this->request->getPost('name'),
                    'image'     => $this->request->getPost('image'),
                    'target'    => $this->request->getPost('target'),
                    'params'    => $params,
                    'parents'   => $this->request->getPost('parents'),
                    'status'    => $this->request->getPost('status'),
            );
            $this->setModel("Menu_item");
            if($this->update($parameters, $data)){
                $this->flash->success("Thành công!");
                $this->response->redirect("admin/menu-item/show/".$menu->id);
                $this->view->disable();
            }
        }

        $this->view->pick("news-config/edit-menu");
    }

    public function clearAction(){
        $this->clearSessionPage();
        $this->flash->success("Thành công!");
        $this->redirect(array("action"=>"index"));
    }

    /*
    ** Sử dụng với form
    */
    public function addMenuBakupAction($type = null, $menu_id = null){
        $this->assets->addJs('backend/js/init_tab.js');
        $this->tag->setTitle('Cấu hình menu: Thêm mới');
        $this->view->title_action   = 'Thêm mới';
        $this->view->type           = $type;
        $this->view->menu_id        = $menu_id;

        // $model = new \Modules\Backend\Models\Menu();
        $f = \Modules\Backend\Forms\News_menu();
        $form = new $f(null, $menu_id);
        die();

        $this->view->form = $form;

        if ($this->request->isPost()) {

            $this->setModel("Menu_item");
            
            // thong tin cau hinh
            foreach ($_POST['params'] as $key => $value) {
                if($key == 'category'){
                    $params .= $key.'='.implode(',', $value).';';
                }else{
                    $params .= $key.'='.$value.';';
                }
            }
            $add = array(
                    'params'    => $params,
            );
            // echo '<pre>';print_r($add);exit;
            $this->save($_POST, null, $add);
        }

        $this->view->pick("news-config/add-menu");
    }

}

/* End of file NewsConfigController.php */
/* Location: ./apps/backend/controllers/NewsConfigController.php */
