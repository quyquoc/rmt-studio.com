<?php

namespace Modules\Frontend\Models;

use Phalcon\Mvc\Model;

class Element extends Model {   

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
    public $image;

    /**
     *
     * @var string
     */
    public $type;

    /**
     *
     * @var string
     */
    public $posi;

    /**
     *
     * @var string
     */
    public $params;

    /**
     *
     * @var string
     */
    public $content;

    /**
     *
     * @var integer
     */
    public $showtitle;

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


    public function columnMap()
    {
        return array(
            'id'        => 'id', 
            'name'      => 'name', 
            'image'     => 'image', 
            'type'      => 'type',
            'posi'      => 'posi',
            'params'    => 'params',
            'content'   => 'content',
            'showtitle' => 'showtitle',
            'status'    => 'status',
            'position'  => 'position'
        );
    }

    public function initialize(){

    }

    public function abc(){
        echo 'hello 123';
    }


}