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
        
		$this->add(new Text("code"));
		$this->add(new Select('status', array('0'=>'Không', '1'=>'Có')));
		$this->add(new Text("position"));
	}
	
}

/* End of file Menu.php */
/* Location: ./apps/backend/forms/Menu.php */
