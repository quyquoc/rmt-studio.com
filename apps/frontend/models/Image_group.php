<?php

namespace Modules\Frontend\Models;

use Phalcon\Mvc\Model;

class Image_group extends Model { 

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