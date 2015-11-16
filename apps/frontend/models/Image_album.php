<?php

namespace Modules\Frontend\Models;

use Phalcon\Mvc\Model;

class Image_album extends Model { 

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
        $this->belongsTo('group_id', '\Modules\Frontent\Models\Image_group', 'id', array(
            'alias' => 'image_group',
            'reusable' => true
        ));
    }

}