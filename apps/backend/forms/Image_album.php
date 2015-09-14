<?php

namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\TextArea,
	Phalcon\Forms\Element\Select,
	Phalcon\Forms\Element\Hidden,
	Phalcon\Validation\Validator\PresenceOf;

class Image_album extends Form {

	public function initialize($model = null){
	
		$title = new Text("title");
		$title->addValidator(new PresenceOf());
		$this->add($title);

		$status = new Select('status', array('0'=>'Không', '1'=>'Có'));
		$status->setDefault('1');
		$this->add($status);
	
		$this->add(new Text("image"));
		$this->add(new Text("position"));
		$this->add(new TextArea("content"));

		$group_id = new Select('group_id', \Modules\Backend\Models\Image_group::find(), array('using' => array('id', 'title'), 'size'=>5));
		$this->add($group_id);
	}
}

/* End of file Image_album.php */
/* Location: ./apps/backend/forms/Image_album.php */

