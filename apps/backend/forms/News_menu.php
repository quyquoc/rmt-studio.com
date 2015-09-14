<?php

namespace 	Modules\Backend\Forms;
use 		Phalcon\Forms\Form,
			Phalcon\Forms\Element\Text,
			Phalcon\Forms\Element\TextArea,
			Phalcon\Forms\Element\Select,
			Phalcon\Forms\Element\Hidden,
			Phalcon\Validation\Validator\PresenceOf;

class News_menu extends Form {

	public function initialize($model = null, $menu_id = null){
		
		$system = new \Modules\Library\System();

		// Main tab
		$name = new Text("name");
		$name->addValidator(new PresenceOf());
		$this->add($name);

		$menu = \Modules\Backend\Models\Menu::findFirst();
		$menu = new Text('menu', array('value'=>$menu->name, 'readonly'=>true));
		$this->add($menu);
	
        $menu_item 	= \Modules\Backend\Models\Menu_item::findByMenu_id($menu_id);
		$menu_item 	= $system->convert_object_to_array($menu_item);
		$data 		= null;
		$system->recursive($menu_item, 0, 1, $data);
		$record 	= $system->getListTreeCategory($data, 'name');
		$menu_item	= new Select('menu_item', $record);
		$this->add($menu_item);

		$status = new Select('status', array('0'=>'Không', '1'=>'Có'));
		$status->setDefault('1');
		$this->add($status);
	
		$target = new Select('target', array('0'=>'Không', '1'=>'Có'));
		$target->setDefault('0');
		$this->add($target);
	
		$this->add(new Text("image"));

		// Config tab
        $result = \Modules\Backend\Models\News_category::find();
		$result = $system->convert_object_to_array($result);
		$data 	= null;
		$system->recursive($result, 0, 1, $data);
		$record = $system->getListTreeCategory($data, 'title');
		$category= new Select('params[category][]', $record);
		$this->add($category);

		$params_show = new Select('params[show]', array( '0'=>'Danh sách bài viết', '1'=>'Kênh thông tin - bài viết'));
		$params_show->setDefault($system->getParams($model, array('name'=>'show', 'default'=>0)));
		$this->add($params_show);
	
		$items = new Text("params[items]", array('class'=>'txt_medium','value'=>"{$system->getParams($model,array('name'=>'items','default'=>10))}"));
		$this->add($items); 

		$params_show_image = new Select('params[show_image]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_show_image->setDefault($system->getParams($model, array('name'=>'show_image', 'default'=>2)));
		$this->add($params_show_image);
	
		$params_link_image = new Select('params[link_image]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_link_image->setDefault($system->getParams($model, array('name'=>'link_image', 'default'=>2)));
		$this->add($params_link_image);
	
		$params_show_title = new Select('params[show_title]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_show_title->setDefault($system->getParams($model, array('name'=>'show_title', 'default'=>2)));
		$this->add($params_show_title);
	
		$params_link_title = new Select('params[link_title]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_link_title->setDefault($system->getParams($model, array('name'=>'link_title', 'default'=>2)));
		$this->add($params_link_title);
	
		$this->add(new Text('params[number_title]'));

		$params_show_description = new Select('params[show_description]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_show_description->setDefault($system->getParams($model, array('name'=>'show_description', 'default'=>2)));
		$this->add($params_show_description);
	
		$params_link_description = new Select('params[link_description]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_link_description->setDefault($system->getParams($model, array('name'=>'link_description', 'default'=>2)));
		$this->add($params_link_description);
	
		$this->add(new Text('params[number_description]'));

		$params_show_published = new Select('params[show_published]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_show_published->setDefault($system->getParams($model, array('name'=>'show_published', 'default'=>2)));
		$this->add($params_show_published);
	
		$params_show_hits = new Select('params[show_hits]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_show_hits->setDefault($system->getParams($model, array('name'=>'show_hits', 'default'=>2)));
		$this->add($params_show_hits);
	}
}

/* End of file News_menu.php */
/* Location: ./apps/backend/forms/News_menu.php */

