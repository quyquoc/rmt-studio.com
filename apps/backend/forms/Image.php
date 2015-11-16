<?php

namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\TextArea,
Phalcon\Forms\Element\Select,
Phalcon\Forms\Element\Hidden,
Phalcon\Validation\Validator\PresenceOf;

class Image extends Form {
	
	public function initialize($model = null){
	
		$system = new \Modules\Library\System();

		// Main tab
		$title = new Text("title");
		$title->addValidator(new PresenceOf());
		$this->add($title);

		$this->add(new Text("code"));

		$status = new Select('status', array('0'=>'Không', '1'=>'Có'));
		$status->setDefault('1');
		$this->add($status);
	
		$this->add(new Select('featured', array('0'=>'Không', '1'=>'Có')));
		$this->add(new Text("image"));
		$this->add(new TextArea("content"));

		$album_id = new Select('album_id', \Modules\Backend\Models\Image_album::find(), array('using' => array('id', 'title'), 'size'=>5));

		$this->add(new Text("position"));
		
		$this->add($album_id);
	}
}

/* End of file Image.php */
/* Location: ./apps/backend/forms/Image.php */
