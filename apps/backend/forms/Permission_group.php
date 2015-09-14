<?php

namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\TextArea,
Phalcon\Forms\Element\Select,
Phalcon\Forms\Element\Hidden,
Phalcon\Validation\Validator\PresenceOf;

class Permission_group extends Form {


	public function initialize(){	
		
		$name = new Text("name");
		$name->addValidator(new PresenceOf(array(
				'message' => 'name'
		)));
        $this->add($name);
        
        $this->add(new Select("permission",array("full"=>"Full","limit"=>"Limit"),array('class'=>'medium')));
		$this->add(new Select('status', array('0'=>'Không', '1'=>'Có'), array('class'=>'medium')));
		$this->add(new Text("position", array('class'=>'txt_medium')));

		$resource_id = new Select('resource_id',\Modules\Backend\Models\Permission_resource::find(), array('using' => array('id', 'name'),'class'=>'medium'));
		$this->add($resource_id);
	}

	
}

/* End of file Permission_group.php */
/* Location: ./apps/backend/forms/Permission_group.php */
