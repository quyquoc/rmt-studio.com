<?php

namespace Modules\Backend\Controllers;
use Modules\Backend\Models\ModelBase;

class IndexController extends ControllerBase
{
   
	protected function initialize(){
        parent::initialize();
        
	}

    public function indexAction(){
    	
        $this->tag->setTitle("CMS");
    }
}

/* End of file IndexController.php */
/* Location: ./apps/backend/controllers/IndexController.php */
