<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;

class Permission_group extends Model {   

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
    public $resource_id;

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
            'resource_id'   =>  'resource_id'
        );
    }
    
    public function initialize(){
	    $this->belongsTo('resource_id', '\Modules\Backend\Models\Permission_resource', 'id', array(
            'alias' => 'resource',
            'reusable' => true
        ));
    }
    

}