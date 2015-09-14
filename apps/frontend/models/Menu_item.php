<?php

namespace Modules\Frontend\Models;

use Phalcon\Mvc\Model;

class Menu_item extends Model {   

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
    public $code;

    /**
     *
     * @var string
     */
    public $image;

    /**
     *
     * @var string
     */
    public $type;

    /**
     *
     * @var integer
     */
    public $target;
    
    /**
     *
     * @var string
     */
    public $params;

    /**
     *
     * @var string
     */
    public $parents;

    /**
     *
     * @var string
     */
    public $menu_id;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var integer
     */
    public $language;

    /**
     *
     * @var string
     */
    public $position;



    public function columnMap()
    {
        return array(
            'id'        =>  'id', 
            'name'      =>  'name', 
            'code'      =>  'code',
            'image'     =>  'image',
            'type'      =>  'type',
            'target'    =>  'target',
            'params'    =>  'params',
            'parents'   =>  'parents',
            'menu_id'   =>  'menu_id',
            'status'    =>  'status', 
            'language'  =>  'language',
            'position'  =>  'position', 
        );
    }

    public function initialize(){

    }

}