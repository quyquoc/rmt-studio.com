<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
class Menu_type extends Model {   

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
     * @var boolean
     */
    public $b_link;

    /**
     *
     * @var string
     */
    public $type;

    /**
     *
     * @var integer
     */
    public $parents;

    /**
     *
     * @var integer
     */
    public $position;

    /**
     *
     * @var string
     */
    public $description;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id'            => 'id', 
            'name'          => 'name', 
            'b_link' 	    => 'b_link', 
            'type'          => 'type', 
            'parents'       => 'parents', 
            'position'      => 'position',
            'description'   => 'description'
        );
    }

}