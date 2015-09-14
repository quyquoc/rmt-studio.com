<?php
namespace Modules\Library\Acl;

use Phalcon\Mvc\User\Component;
use Modules\Library\Auth\Auth as Auth;
use Modules\Backend\Module;
use Phalcon\Acl\Adapter\Memory as AcList;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;

class Acl extends Component {
    /**
     * Hàm khởi tạo   
     *
     */
    public function __construct(){
    	
    	$resources = $this->getInfoPermission();
    }
    
    
    /**
     * Checks if the current profile is allowed to access a resource
     *
     * @param string $profile
     * @param string $controller
     * @param string $action
     * @return boolean
     */
    public function isAllowed($profile, $controller, $action){
    	if($this->getAcl()){
    		return $this->getAcl()->isAllowed($profile, $controller, $action);
    	}
    }
    
    /**  
     * Hàm lấy thông tin nhóm nhóm quyềnh
     */
    private function getInfoPermission(){
  
    	$auth = new Auth();
    	$identity = $auth->getIdentity();
  		if($identity != null){
  			
  			$conditions = "id = :id: AND status = 1";
  			// lấy thông tin group
  			$group = \Modules\Backend\Models\Permission_group::findFirst(array("conditions" => $conditions, "bind" => array("id" => $identity['group_id'])));
           
			if(!$group){
				return false;
			}
			
			$conditions = "group_id = :group_id: AND status = 1";
  			$group_privilege = \Modules\Backend\Models\Permission_group_privilege::find(array("conditions" => $conditions,"bind" => array("group_id" => $group->id)));
  			
  			if(count($group_privilege) <= 0){
            	return false;	
  			}
  			
  			return $group_privilege;
  		}  	
    	   
    	return false;
    }
    
    
    public function getAcl(){
    	
    	$auth = new Auth();
    	if(!empty($auth->getPermission())){
    		$acl = new AcList();
    		// Default action is deny access
    		$acl->setDefaultAction(\Phalcon\Acl::DENY);
    		$role = new Role($auth->getPermission());
    		// Add "Guests" role to acl
    		$acl->addRole($role);
    		 
    		$info = $this->getInfoPermission();
    		
    		foreach ($info as $k => $v){  
    			$acl->addResource(new Resource($v->privilege->controller), $v->privilege->action);
    			$acl->allow($auth->getPermission(), $v->privilege->controller, $v->privilege->action);
    		}
    		
    		return $acl;
    	
    	} else {
    		return false;	
    	}
    }
}
