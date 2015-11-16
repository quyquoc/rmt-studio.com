<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;

class Image extends Model { 


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
     *  @var string
     */
    public $content;

    /**
     *
     * @var integer
     */
    public $album_id;

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
    public $hits;

    /**
     *
     * @var string
     */
    public $created;

    /**
     *
     * @var string
     */
    public $updated;

    /**
     *
     * @var string
     */
    public $creator_id;

    /**
     *
     * @var string
     */
    public $editor_id;

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
            'image'         =>  'image',
            'attr_image'    =>  'attr_image',
            'content'       =>  'content',
            'album_id'      =>  'album_id',
            'featured'      =>  'featured',
            'status'        =>  'status',
            'hits'          =>  'hits',
            'created'       =>  'created',
            'updated'       =>  'updated',
            'creator_id'    =>  'creator_id',
            'editor_id'     =>  'editor_id',
            'position'    	=>  'position', 
        );
    }

    public function initialize(){
        $this->belongsTo('creator_id', '\Modules\Backend\Models\Member', 'id', array(
            'alias' => 'member',
            'reusable' => true
        ));
        $this->belongsTo('album_id', '\Modules\Backend\Models\Image_album', 'id', array(
            'alias' => 'image_album',
            'reusable' => true
        ));
    }

}