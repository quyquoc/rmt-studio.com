<?php

namespace Modules\Frontend\Models;

use Phalcon\Mvc\Model;

class Contact extends Model { 

	/**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $fullname;

    /**
     *
     * @var string
     */
    public $from_mail;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *  @var string
     */
    public $content;

    /**
     *  @var integer
     */
    public $status;

    /**
     *  @var datetime
     */
    public $send_date;

    /**
     *
     * @var integer
     */
    public $position;

    public function columnMap(){
        return array(
            'id'            =>  'id', 
            'fullname'      =>  'fullname', 
            'from_mail'    =>  'from_mail',
            'title'         =>  'title', 
            'content'       =>  'content',
            'status'        =>  'status',
            'send_date'     =>  'send_date',
            'position'    	=>  'position',
        );
    }
}

/* End of file Contact.php */
/* Location: ./apps/frontend/controllers/Contact.php */
