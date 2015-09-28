<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;

class News_article extends Model { 


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
    public $description;

    /**
     *  @var string
     */
    public $content;

    /**
     *  @var integer
     */
    public $feature;

    /**
     *
     * @var string
     */
    public $image;

    /**
     *
     * @var string
     */
    public $link;

    /**
     *
     * @var string
     */
    public $url_target;

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
     * @var string
     */
    public $seo_title;

    /**
     *
     * @var string
     */
    public $metadata;

    /**
     *
     * @var string
     */
    public $keyword;

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
    public $category_id;

    /**
     *
     * @var string
     */
    public $published;

    /**
     *
     * @var integer
     */
    public $position;

    public function columnMap(){
        return array(
            'id'        	=>  'id', 
            'title'         =>  'title', 
            'code'      	=>  'code', 
            'description'   =>  'description',
            'content'       =>  'content',
            'feature'       =>  'feature',
            'image'         =>  'image',
            'link'			=>  'link',
            'url_target'    =>  'url_target',
            'status'        =>  'status',
            'params'        =>  'params',
            'seo_title'     =>  'seo_title',
            'metadata'      =>  'metadata',
            'keyword'       =>  'keyword',
            'hits'          =>  'hits',
            'created'       =>  'created',
            'updated'       =>  'updated',
            'creator_id'    =>  'creator_id',
            'editor_id'     =>  'editor_id',
            'category_id'   =>  'category_id',
            'published'     =>  'published',
            'position'    	=>  'position', 
        );
    }

    public function initialize(){
        $this->belongsTo('creator_id', '\Modules\Backend\Models\Member', 'id', array(
            'alias' => 'member',
            'reusable' => true
        ));
        $this->belongsTo('category_id', '\Modules\Backend\Models\News_category', 'id', array(
            'alias' => 'news_category',
            'reusable' => true
        ));
    }

}