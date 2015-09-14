<?php

namespace Modules\Backend\Controllers;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class LoginController extends Controller{
    public function initialize(){
        
    }

    public function indexAction()
    {
    	//Add some local CSS and JS resources
        $this->assets->addCss('backend/css/login.css');
        $this->assets->addJs('backend/js/jquery-1.8.2.min.js')->addJs('backend/js/md5.js');

        $this->tag->setTitle("Login");

    	$this->view->disableLevel(View::LEVEL_LAYOUT);
    	$this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
    
        $form = new \Modules\Backend\Forms\Login();

        // Nếu bấm login
        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost())) {
                $auth = new \Modules\Library\Auth\Auth();
                $check = $auth->check(array(
                		'username' => $this->request->getPost('username'),
                		'password' => $this->request->getPost('password'),
                ));
                
                if($check){ // Đăng nhập thành công
                	$this->flash->success("Đăng nhập thành công!");
                	$this->response->redirect('admin');
                } else { // Đăng nhâp thất bại
                	$this->response->redirect('admin/login');
                }
            }
        } 

        $this->view->form = $form;
    }
    
    /**
     * Closes the session
     */
    public function logoutAction(){
    	$auth = new \Modules\Library\Auth\Auth();
    	$auth->remove();
    	$this->response->redirect('admin/login');
    }
}

/* End of file LoginController.php */
/* Location: ./apps/backend/controllers/LoginController.php */
