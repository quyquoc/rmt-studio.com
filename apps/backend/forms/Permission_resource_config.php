<?php

namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\TextArea,
Phalcon\Forms\Element\Select,
Phalcon\Forms\Element\Hidden,
Phalcon\Validation\Validator\PresenceOf;

class Permission_resource_config extends Form {


	public function initialize(){	
		
		$resource_id = new Select('resource_id',\Modules\Backend\Models\Permission_resource::find(), array('using' => array('id', 'name'),'class'=>'medium'));
		$this->add($resource_id);

		$config_id = new Select('config_id',\Modules\Backend\Models\Permission_config::find(), array('using' => array('id', 'name'),'class'=>'medium'));
		$this->add($config_id);
	}
	
}

/* End of file Member_department.php */
/* Location: ./apps/backend/forms/Member_department.php */
