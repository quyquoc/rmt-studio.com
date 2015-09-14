<?php
namespace Modules\Library\Auth;

use Phalcon\Mvc\User\Component;

/**
 * Modules\Auth\Auth
 * Manages Authentication/Identity Management
 */
class Auth extends Component
{

    /**
     * Checks the user credentials
     *
     * @param array $credentials
     * @return boolan
     */
    public function check($credentials)
    {
		
        // Check if the user exist
        $conditions = "(email = :email: OR username = :username:) AND status = '1'";

        $member = \Modules\Backend\Models\Member::findFirst(array("conditions" => $conditions,"bind" => array("email" => $credentials['username'],"username" => $credentials['username'])));

        if (!$member) { // không đúng tài khoản hoặc email thì return
        	return false;
        }
        
        // Kiểm tra  password đúng hay không
        $hash = new \Modules\Library\Hash();
        if($member->password !== $hash->create($credentials['password'],$member->salt)){ 
        	return false;
        } 

        $this->session->set('auth-identity', array(
            'id' 			=> $member->id,
            'username' 		=> $member->username,
        	'firstname' 	=> $member->firstname,
        	'lastname' 		=> $member->lastname,
            'group_id'      => $member->group_id,
            'permission' 	=> $member->permission_group->permission,
            'resource'      => $member->permission_group->resource_id  
        ));
        
        //Cấp quyen Update FILE bằng CKFINDER
        $this->setPermissionCKFinder();

        return true;
    }


    /**
     * Returns the current identity
     *
     * @return array
     */
    public function getIdentity()
    {
        return $this->session->get('auth-identity');
    }

    /**
     * Returns the current identity Username
     *
     * @return string
     */
    public function getUserName()
    {
        $identity = $this->session->get('auth-identity');
        return $identity['username'];
    }


    /**
     * Returns the current identity
     *
     * @return string
     */
    public function getPermission()
    {
    	$identity = $this->session->get('auth-identity');
    	return $identity['permission'];
    }
    
    /**
     * Get the entity related to user in the active identity
     *
     * @return \Models\Backend\Models\Member
     */
    public function getMember()
    {
        $identity = $this->session->get('auth-identity');
        if (isset($identity['id'])) {

            $member = \Modules\Backend\Models\Member::findFirstById($identity['id']);
            if ($member) {
               return $member;
            }
        }
        return false;
    }
    
    /**
     * Removes the user identity information from session
     */
    public function remove()
    {
    	$this->session->remove('auth-identity');
        $this->session->remove('ckfinder');
    }


    // Set quyenh truy cập vào CKinder và đường dẫn chưa tài nguyên + được truy xuất vào folder
    private function setPermissionCKFinder(){
        $identity = $this->session->get('auth-identity'); 
        $resource_id = $identity['resource'];

        $conditions = "id = :id: AND status = 1";
            
        $resource = \Modules\Backend\Models\Permission_resource::findFirst(array("conditions" => $conditions, "bind" => array("id" => $resource_id)));

        $this->session->set('ckfinder', array(
            'BaseUrl'       =>  UPLOAD_DIR,
            'IsAuthorized'  =>  true,  
            'Permission'    =>  $resource->permission
        ));
        // Tồn tại nhóm quyền resource
        if($resource){
            
            if($resource->permission == "full"){
                $_SESSION['ckfinder']['AccessControl'][] = Array(
                    'role' => '*',
                    'resourceType' => '*',
                    'folder' => '/',

                    'folderView'    => true,
                    'folderCreate'  => true,
                    'folderRename'  => true,
                    'folderDelete'  => true,

                    'fileView'      => true,
                    'fileUpload'    => true,
                    'fileRename'    => true,
                    'fileDelete'    => true
                );
            } else {
                $_SESSION['ckfinder']['AccessControl'][] = Array(
                    'role' => '*',
                    'resourceType' => '*',
                    'folder' => '/',

                    'folderView'    => true,
                    'folderCreate'  => true,
                    'folderRename'  => true,
                    'folderDelete'  => true,

                    'fileView'      => false,
                    'fileUpload'    => true,
                    'fileRename'    => true,
                    'fileDelete'    => true
                );
                $conditions = "resource_id = :resource_id:";
                $resource_config = \Modules\Backend\Models\Permission_resource_config::find(array("conditions" => $conditions,"bind" => array("resource_id" => $resource_id)));

                foreach ($resource_config as $key => $value) {

                    $_SESSION['ckfinder']['AccessControl'][] = Array(
                        'role' => '*',
                        'resourceType' => $value->config->type,
                        'folder' => '/'.$value->config->folder,

                        'folderView'    => $value->config->folder_view ==   1 ? true : false,
                        'folderCreate'  => $value->config->folder_create == 1 ? true : false,
                        'folderRename'  => $value->config->folder_rename == 1 ? true : false,
                        'folderDelete'  => $value->config->folder_delete == 1 ? true : false,

                        'fileView'      => $value->config->file_view ==     1 ? true : false,
                        'fileUpload'    => $value->config->file_upload ==   1 ? true : false,
                        'fileRename'    => $value->config->file_rename ==   1 ? true : false,
                        'fileDelete'    => $value->config->file_delete ==   1 ? true : false,
                    );
                }
            }
        } else { // Tắt kích hoạt resource -> Không truy cập vào folder được

            $_SESSION['ckfinder']['AccessControl'][] = Array(
                'role' => '*',
                'resourceType' => '*',
                'folder' => '/',

                'folderView'    => false,
                'folderCreate'  => false,
                'folderRename'  => false,
                'folderDelete'  => false,

                'fileView'      => false,
                'fileUpload'    => false,
                'fileRename'    => false,
                'fileDelete'    => false
            );
        }
    }
}

/* End of file Auth.php */
/* Location: ./apps/library/Auth/Auth.php */
