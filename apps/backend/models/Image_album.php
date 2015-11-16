<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;

class Image_album extends Model { 

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
    public $attr_image;

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
    public $group_id;

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
            'attr_image'    =>  'attr_image',
            'content'       =>	'content',
            'featured'      =>  'featured',
            'group_id'      =>  'group_id',
            'status'    	=>  'status',
            'position'    	=>  'position', 
        );
    }

    public function initialize(){
        $this->belongsTo('group_id', '\Modules\Backend\Models\Image_group', 'id', array(
            'alias' => 'image_group',
            'reusable' => true
        ));
    }

}