<?php

namespace Modules\Frontend\Models;

use Phalcon\Mvc\Model;

class News_category extends Model { 


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
    public $description;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var text
     */
    public $params;

    /**
     *
     * @var integer
     */
    public $position;

    /**
     *
     * @var integer
     */
    public $parents;

    public function columnMap(){
        return array(
            'id'        	=>  'id', 
            'title'      	=>  'title', 
            'code'          =>  'code',
            'image'			=>  'image',
            'description'	=>	'description',
            'status'    	=>  'status', 
            'params'        =>  'params',
            'position'    	=>  'position', 
            'parents'		=>	'parents'
        );
    }

    public function initialize(){
    
    }

    
    /**
     *  Hàm get số padding và class của level tương ứng
     *  @param $level integer
     *  @return string padding
     */
    public function getLevel($level = null,$task = null){
        if($task == "padding"){
            $padding = '0px';
            if($level == 1){
                $padding = '5px';
            }else{
                $padding = 22 * ($level - 1).'px';
            }
            return $padding;    
        } else if($task == "class"){
            if($level > 1){
                return "level_category";
            } else {
                return null;
            }
        }
    }

}