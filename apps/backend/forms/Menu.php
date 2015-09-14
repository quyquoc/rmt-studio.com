<?php

namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\TextArea,
Phalcon\Forms\Element\Select,
Phalcon\Forms\Element\Hidden,
Phalcon\Validation\Validator\PresenceOf;

class Menu extends Form {


	public function initialize(){	
		
		$name = new Text("name");
		$name->addValidator(new PresenceOf(array(
				'message' => 'name'
		)));
        $this->add($name);
        
		$this->add(new Select('status', array('0'=>'Không', '1'=>'Có'), array('class'=>'medium')));
		$this->add(new Text("position", array('class'=>'txt_medium')));
	}
	
}

/* End of file Menu.php */
/* Location: ./apps/backend/forms/Menu.php */
