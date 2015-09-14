<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;

class Member_department extends Model {   

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var string
     */
    public $position;

    /**
     *
     * @var string
     */
    public $created;

    public function columnMap(){
        return array(
            'id'        =>  'id', 
            'name'      =>  'name', 
            'status'    =>  'status', 
            'position'  =>  'position', 
            'created'   =>  'created'
        );
    }

    public function initialize(){

        $this->hasMany('id', '\Modules\Backend\Models\Member', 'department_id', array(
            'alias' => 'member',
            'foreignKey' => array(
                'message' => 'Profile cannot be deleted because it\'s used on Users'
            )
        ));
    }

}