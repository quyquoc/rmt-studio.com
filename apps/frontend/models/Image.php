<?php

namespace Modules\Frontend\Models;

use Phalcon\Mvc\Model;

class Image extends Model { 

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
        $this->belongsTo('creator_id', '\Modules\Frontent\Models\Member', 'id', array(
            'alias' => 'member',
            'reusable' => true
        ));
        $this->belongsTo('album_id', '\Modules\Frontent\Models\Image_album', 'id', array(
            'alias' => 'image_album',
            'reusable' => true
        ));
    }

}