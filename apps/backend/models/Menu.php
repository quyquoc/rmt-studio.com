<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;

class Menu extends Model {   

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

    public function columnMap()
    {
        return array(
            'id'        =>  'id', 
            'name'      =>  'name', 
            'status'    =>  'status', 
            'position'  =>  'position', 
            'created'   =>  'created'
        );
    }

    public function initialize(){

        $this->hasMany('id', '\Modules\Backend\Models\Menu_item', 'menu_id', array(
            'alias' => 'menu_item',
            'foreignKey' => array(
                'message' => 'Profile cannot be deleted because it\'s used on Users'
            )
        ));
    }

}