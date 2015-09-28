<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;

class Menu_item extends Model {   

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
    public $code;

    /**
     *
     * @var string
     */
    public $link;

    /**
     *
     * @var string
     */
    public $image;

    /**
     *
     * @var integer
     */
    public $target;

    /**
     *
     * @var string
     */
    public $posi;

    /**
     *
     * @var string
     */
    public $parents;

    /**
     *
     * @var string
     */
    public $menu_id;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var integer
     */
    public $language;

    /**
     *
     * @var string
     */
    public $position;



    public function columnMap()
    {
        return array(
            'id'        =>  'id', 
            'name'      =>  'name', 
            'code'      =>  'code',
            'link'      =>  'link',
            'image'     =>  'image',
            'target'    =>  'target',
            'posi'      =>  'posi',
            'params'    =>  'params',
            'parents'   =>  'parents',
            'menu_id'   =>  'menu_id',
            'status'    =>  'status', 
            'language'  =>  'language',
            'position'  =>  'position', 
        );
    }

    public function initialize(){
        $this->belongsTo('menu_id', '\Modules\Backend\Models\Menu', 'id', array(
            'alias' => 'menu',
            'reusable' => true
        ));
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