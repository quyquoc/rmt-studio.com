<?php

namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\TextArea,
Phalcon\Forms\Element\Select,
Phalcon\Forms\Element\Hidden,
Phalcon\Validation\Validator\PresenceOf;

class News_category extends Form {

	public function initialize($model = null){
	
		$system = new \Modules\Library\System();

		// Main tab
		$title = new Text("title");
		$title->addValidator(new PresenceOf());
		$this->add($title);

		$status = new Select('status', array('0'=>'Không', '1'=>'Có'));
		$status->setDefault('1');
		$this->add($status);
	
		$this->add(new Text("image"));
		$this->add(new TextArea("description"));
		$this->add(new Text("position"));

        $result = \Modules\Backend\Models\News_category::find();
        $system = new \Modules\Library\System();
		$result = $system->convert_object_to_array($result);
		$data 	= null;
		$system->recursive($result,0,1,$data);
		$record = $system->getListTreeCategory($data, 'title');
		$parents= new Select('parents', $record);
		$this->add($parents);
	}
}

/* End of file News_category.php */
/* Location: ./apps/backend/forms/News_category.php */

