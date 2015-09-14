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

		$status = new Select('status', array('0'=>'Không', '1'=>'Có'));
		$status->setDefault('1');
		$this->add($status);
	
		$this->add(new Select('feature', array('0'=>'Không', '1'=>'Có')));
		$this->add(new Text("image"));
		$this->add(new TextArea("content"));

		// Config tab	
		$params_show_title = new Select('params[show_title]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_show_title->setDefault($system->getParams($model,array('name'=>'show_title','default'=>2)));
		$this->add($params_show_title);

		$params_description = new Select('params[show_content]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_description->setDefault($system->getParams($model,array('name'=>'content','default'=>2)));
		$this->add($params_description);

		$params_show_published = new Select('params[show_published]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_show_published->setDefault($system->getParams($model,array('name'=>'show_published','default'=>2)));
		$this->add($params_show_published);
		
		$params_show_hits = new Select('params[show_hits]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_show_hits->setDefault($system->getParams($model,array('name'=>'show_hits','default'=>2)));
		$this->add($params_show_hits);
		
		$this->add(new Text("published", array('data-format'=>'yyyy-MM-dd hh:mm:ss', 'value'=>date('d-m-Y H:i:s'))));
		
		$album_id = new Select('album_id', \Modules\Backend\Models\Image_group::find(), array('using' => array('id', 'title'), 'size'=>5));

		$this->add(new Text("position"));
		
		$this->add($album_id);
	}
}

/* End of file Image.php */
/* Location: ./apps/backend/forms/Image.php */
