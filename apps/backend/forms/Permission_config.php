<?php

namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\TextArea,
Phalcon\Forms\Element\Select,
Phalcon\Forms\Element\Hidden,
Phalcon\Validation\Validator\PresenceOf;

class Permission_config extends Form {


	public function initialize(){	
		
		$name = new Text("name");
		$name->addValidator(new PresenceOf(array(
				'message' => 'name'
		)));
        $this->add($name);

        $folder = new Text("folder");
		$folder->addValidator(new PresenceOf(array(
				'message' => 'folder'
		)));
        $this->add($folder);

        $this->add(new Select('type', array('Images'=>'Images', 'Files'=>'Files','Flash'=>'Flash'), array('class'=>'medium')));
        $this->add(new Select('folder_view', array('0'=>'Không', '1'=>'Có'), array('class'=>'medium')));
        $this->add(new Select('folder_create', array('0'=>'Không', '1'=>'Có'), array('class'=>'medium')));
        $this->add(new Select('folder_rename', array('0'=>'Không', '1'=>'Có'), array('class'=>'medium')));
        $this->add(new Select('folder_delete', array('0'=>'Không', '1'=>'Có'), array('class'=>'medium')));

        $this->add(new Select('file_view', array('0'=>'Không', '1'=>'Có'), array('class'=>'medium')));
        $this->add(new Select('file_upload', array('0'=>'Không', '1'=>'Có'), array('class'=>'medium')));
        $this->add(new Select('file_rename', array('0'=>'Không', '1'=>'Có'), array('class'=>'medium')));
        $this->add(new Select('file_delete', array('0'=>'Không', '1'=>'Có'), array('class'=>'medium')));

		$this->add(new Select('status', array('0'=>'Không', '1'=>'Có'), array('class'=>'medium')));

	}
	
}

/* End of file Member_department.php */
/* Location: ./apps/backend/forms/Member_department.php */
