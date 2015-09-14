<?php

namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\TextArea,
Phalcon\Forms\Element\Select,
Phalcon\Forms\Element\Hidden,
Phalcon\Validation\Validator\PresenceOf;

class Permission_privilege extends Form {


	public function initialize(){	
		
		$name = new Text("name");
		$name->addValidator(new PresenceOf(array(
				'message' => 'name'
		)));
        $this->add($name);

        $controller = new Text("controller");
		$controller->addValidator(new PresenceOf(array(
				'message' => 'controller'
		)));
        $this->add($controller);

        $action = new Text("action");
		$action->addValidator(new PresenceOf(array(
				'message' => 'action'
		)));
        $this->add($action);

        $position = new Text("position");
        $this->add($position);
	}
	
}

/* End of file Permission_group.php */
/* Location: ./apps/backend/forms/Permission_privilege.php */
