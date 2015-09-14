<?php

namespace Modules\Backend\Controllers;
use Modules\Backend\Library\Hash as Hash;
use Phalcon\Mvc\View;

class AuthenticateController extends ControllerBase{

    protected function initialize(){
        parent::initialize();
        $this->setModel("Member");
    }

    public function indexAction()
    {
        die("OK");	
    }

    public function loginAction(){
        if ($this->request->isPost() == true) {
            $username = $this->request->getPost('username');
            if(!empty($username)){
                $conditions = "(email = :email: OR username = :username:) AND status = '1'";
                $parameters = array('email' => $username,'username' => $username);
                $member = $this->findFirst(array($conditions,"bind"=>$parameters));
                if($member){
                    $password = $this->request->getPost('password');
                    $hash = new Hash();
                    if($member->password === $hash->create($password,$member->salt)){
                        $this->response->redirect('admin');
                    } else {
                        $this->response->redirect('login');
                    }
                } else {
                    $this->response->redirect('login');
                }
            }
        } else {
            $this->response->redirect('login');
            $this->view->disable();
        }
    }
}

/* End of file AuthenticateController.php */
/* Location: ./apps/backend/controllers/AuthenticateController.php */
