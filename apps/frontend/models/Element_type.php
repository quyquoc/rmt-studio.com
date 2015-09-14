<?php

namespace Modules\Frontend\Models;

use Phalcon\Mvc\Model;

class Element_type extends Model {   

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
    public $type;

    /**
     *
     * @var string
     */
    public $type;


    public function columnMap()
    {
        return array(
            'id'        =>  'id', 
            'name'      =>  'name', 
            'position'  =>  'position', 
            'type'      =>  'type'
        );
    }

    public function initialize(){

    }


}