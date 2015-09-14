<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
class Member extends Model {   

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $firstname;

    /**
     *
     * @var string
     */
    public $lastname;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $salt;

    /**
     *
     * @var string
     */
    public $avatar;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var integer
     */
    public $gender;

    /**
     *
     * @var string
     */
    public $birthday;

     /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var string
     */
    public $phone;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var integer
     */
    public $department_id;

    /**
     *
     * @var integer
     */
    public $group_id;

    /**
     *
     * @var string
     */
    public $created;

    /**
     *
     * @var string
     */
    public $creater_id;

    /**
     *
     * @var string
     */
    public $modified;

    /**
     *
     * @var string
     */
    public $modifier_id;

    /**
     *
     * @var string
     */
    public $visited;

    /**
     *
     * @var integer
     */
    public $position;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'firstname' 	=> 	'firstname', 
            'lastname' 		=> 	'lastname', 
            'username' 		=> 	'username', 
            'password' 		=> 	'password', 
            'salt'			=> 	'salt', 
            'avatar'		=>	'avatar',
            'email'			=>	'email',
            'gender' 		=> 	'gender', 
            'birthday'		=>	'birthday',
            'address' 		=> 	'address',
            'phone' 		=> 	'phone', 
            'status' 		=> 	'status', 
            'department_id'	=>	'department_id',
            'group_id' 		=> 	'group_id',
            'created' 		=> 	'created',
            'creater_id'	=>	'creater_id' ,
            'modified'		=>	'modified',
            'modifier_id'	=>	'modifier_id',
            'visited'		=>	'visited',	
            'position' 		=> 	'position'
        );
    }

    public function initialize(){
        $this->belongsTo('department_id', '\Modules\Backend\Models\Member_department', 'id', array(
            'alias' => 'department',
            'reusable' => true
        ));

        $this->belongsTo('group_id', '\Modules\Backend\Models\Permission_group', 'id', array(
            'alias' => 'permission_group',
            'reusable' => true
        ));
    }

    public function validation()
    {   
        $this->validate(new UniquenessValidator(array(
            'field' => 'email',
            'message' => 'Sorry, The email was registered by another user'
        )));
        $this->validate(new UniquenessValidator(array(
            'field' => 'username',
            'message' => 'Sorry, That username is already taken'
        )));
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}