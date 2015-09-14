<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;

class Permission_resource extends Model {   

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
     * @var string
     */
    public $permission;

    /**
     *
     * @var integer
     */
    public $status;


    /**
     *
     * @var integer
     */
    public $position;

    public function columnMap()
    {
        return array(
            'id'        =>  'id', 
            'name'      =>  'name', 
            'permission'=>  'permission',
            'status'    =>  'status', 
            'position'  =>  'position', 
        );
    }
    
    public function initialize(){
	
    }
    

}