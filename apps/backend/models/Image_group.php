<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;

class Image_group extends Model { 

    /**
     *  @var database
     */
    public $db;

	/**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $title;

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
    public $content;

    /**
     *  @var integer
     */
    public $featured;

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

    public function columnMap(){
        return array(
            'id'        	=>  'id', 
            'title'      	=>  'title', 
            'code'          =>  'code',
            'image'			=>  'image',
            'content'       =>	'content',
            'featured'      =>  'featured',
            'status'    	=>  'status',
            'position'    	=>  'position', 
        );
    }

    public function initialize(){
        
    }

}