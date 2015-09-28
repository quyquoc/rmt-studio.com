<?php

namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\TextArea,
Phalcon\Forms\Element\Select,
Phalcon\Forms\Element\Hidden,
Phalcon\Validation\Validator\PresenceOf;

class Menu_item extends Form {


	public function initialize($model, $menu_id = null){	

        $system = new \Modules\Library\System();

		// Main tab
		$name = new Text("name");
		$name->addValidator(new PresenceOf(array('message' => 'name')));
        $this->add($name);
        
		$this->add(new Text("code"));

		$link = new Text("link");
		$link->addValidator(new PresenceOf(array('message' => 'link')));
        $this->add($link);

		// parents menu item
		$result 	= \Modules\Backend\Models\Menu_item::findByMenu_id($menu_id);
		$result 	= $system->convert_object_to_array($result);
		$data 		= null;
		$system->recursive($result, 0, 1, $data);
		$data 		= $system->getListTreeCategory($data, 'name');
		$parents 	= new Select('parents', $data);
		$this->add($parents);

		$tbl_menu 	= \Modules\Backend\Models\Menu::find();
		$menu 		= new Select('menu_id', $tbl_menu, array('using'=>array('id', 'name')));
		$menu->setDefault($menu_id);
		$this->add($menu);

		$status = new Select('status', array('0'=>'Không', '1'=>'Có'));
		$status->setDefault('1');
		$this->add($status);

		$target = new Select('target', array('0'=>'Bình thường', '1'=>'Mở tab mới'));
		$this->add($target);
		
		$this->add(new Text("image"));
		$this->add(new Text("position"));
	}	
}

/* End of file Menu_item.php */
/* Location: ./apps/backend/forms/Menu_item.php */
