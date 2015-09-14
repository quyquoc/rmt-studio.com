<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
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
     * @var integer
     */
    public $position;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id'        => 'id', 
            'name' 	    => 'name', 
            'type'      => 'type', 
            'position' 	=> 'position'
        );
    }

}