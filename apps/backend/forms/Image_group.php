<?php

namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\TextArea,
	Phalcon\Forms\Element\Select,
	Phalcon\Forms\Element\Hidden,
	Phalcon\Validation\Validator\PresenceOf;

class Image_group extends Form {

	public function initialize($model = null){
	
		$title = new Text("title");
		$title->addValidator(new PresenceOf());
		$this->add($title);

		$this->add(new Text("code"));

		$status = new Select('status', array('0'=>'Không', '1'=>'Có'));
		$status->setDefault('1');
		$this->add($status);
	
		$this->add(new Text("image"));
		$this->add(new Text("position"));
		$this->add(new TextArea("content"));
	}
}

/* End of file Image_group.php */
/* Location: ./apps/backend/forms/Image_group.php */

