<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;

class Permission_config extends Model {   

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
    public $folder;

    /**
     *
     * @var string
     */
    public $type;

    /**
     *
     * @var string
     */
    public $folder_view;

    /**
     *
     * @var string
     */
    public $folder_create;

    /**
     *
     * @var string
     */
    public $folder_rename;

    /**
     *
     * @var string
     */
    public $folder_delete;

    /**
     *
     * @var string
     */
    public $file_view;

    /**
     *
     * @var string
     */
    public $file_upload;

    /**
     *
     * @var string
     */
    public $file_rename;

    /**
     *
     * @var string
     */
    public $file_delete;

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

    public function columnMap()
    {
        return array(
            'id'            =>  'id', 
            'name'          =>  'name', 
            'type'          =>  'type',
            'folder'        =>  'folder',
            'folder_view'   =>  'folder_view',
            'folder_create' =>  'folder_create',
            'folder_rename' =>  'folder_rename',
            'folder_delete' =>  'folder_delete',
            'file_view'     =>  'file_view',
            'file_create'   =>  'file_create',
            'file_rename'   =>  'file_rename',
            'file_upload'   =>  'file_upload',
            'file_delete'   =>  'file_delete',
            'status'        =>  'status',  
        );
    }
    
    public function initialize(){
	
    }
    

}