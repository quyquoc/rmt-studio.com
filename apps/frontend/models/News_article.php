<?php

namespace Modules\Frontend\Models;

use Phalcon\Mvc\Model;

class News_article extends Model { 

    public function columnMap(){
        return array(
            'id'        	=>  'id', 
            'title'         =>  'title', 
            'code'      	=>  'code', 
            'description'   =>  'description',
            'content'       =>  'content',
            'featured'      =>  'featured',
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
        $this->belongsTo('category_id', '\Modules\Frontend\Models\News_category', 'id', array(
            'alias' => 'news_category',
            'reusable' => true
        ));
    } 
}

/* End of file News_article.php */
/* Location: ./apps/frontend/controllers/News_article.php */
