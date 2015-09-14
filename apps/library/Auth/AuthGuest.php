<?php
namespace Modules\Library\Auth;

use Phalcon\Mvc\User\Component;

/**
 * Modules\Auth\Auth
 * Manages Authentication/Identity Management
 */
class AuthGuest extends Component
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
        $conditions = "(email = :email: OR username = :username:)";

        $guest = \Modules\Frontend\Models\Guest::findFirst(array("conditions" => $conditions,"bind" => array("email" => $credentials['username'],"username" => $credentials['username'])));
        if(!$guest){
            return 3; // // không đúng tài khoản hoặc email
        } else {
            if ($guest->status == 0) { 
                return 2; //tài khoản chưa kích hoạt
            }
            // Kiểm tra  password đúng hay không
            $hash = new \Modules\Library\Hash();
            if($guest->password !== $hash->create($credentials['password'],$guest->salt)){ 
                return 1; // Không đúng mật khẩu
            } 

            $this->session->set('auth-guest', array(
                'id'            => $guest->id,
                'username'      => $guest->username,
                'firstname'     => $guest->firstname,
                'lastname'      => $guest->lastname,
                'permission'    => $guest->guest_group->permission, 
            ));
            
            return 0;
        }
    }


    /**
     * Returns the current identity
     *
     * @return array
     */
    public function getIdentity()
    {
        return $this->session->get('auth-guest');
    }

    /**
     * Returns the current identity Username
     *
     * @return string
     */
    public function getUserName()
    {
        $identity = $this->session->get('auth-guest');
        return $identity['username'];
    }


    /**
     * Returns the current identity
     *
     * @return string
     */
    public function getPermission()
    {
    	$identity = $this->session->get('auth-guest');
    	return $identity['permission'];
    }
    
    /**
     * Get the entity related to user in the active identity
     *
     * @return \Models\Backend\Models\Member
     */
    public function getGuest()
    {
        $identity = $this->session->get('auth-guest');
        if (isset($identity['id'])) {

            $member = \Modules\Frontend\Models\Guest::findFirstById($identity['id']);
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
    	$this->session->remove('auth-guest');
        $this->session->remove('ckfinder');
    }


}

/* End of file Auth.php */
/* Location: ./apps/library/Auth/AuthGuest.php */
