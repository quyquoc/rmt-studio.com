<?php

namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\TextArea,
Phalcon\Forms\Element\Select,
Phalcon\Forms\Element\Hidden,
Phalcon\Forms\Element\Password,
Phalcon\Validation\Validator\PresenceOf,
Phalcon\Validation\Validator\Email;

class Element extends Form {

	public function initialize(){	

        $name = new Text("name");
        $name->setFilters(array('striptags', 'string'));
		$name->addValidators(array(new PresenceOf()));
        $this->add($name);
        
        $this->add(new Text("image", array('class'=>'txt_medium')));

        $this->add(new Text("type", array('class'=>'txt_medium')));
        
        $this->add(new Text("posi", array('class'=>'txt_medium')));
        
        $this->add(new TextArea("content"));
		

		$this->add(new Select('showtitle',array('0'=>'Không','1'=>'Có'),array('class'=>'medium')));
		$this->add(new Select('status',array('0'=>'Không','1'=>'Có'),array('class'=>'medium')));
		$this->add(new Text("position", array('class'=>'txt_medium')));
	}
}

/* End of file Element.php */
/* Location: ./apps/backend/forms/Element.php */
