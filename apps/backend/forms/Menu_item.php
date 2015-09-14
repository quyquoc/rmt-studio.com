<?php

namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\TextArea,
Phalcon\Forms\Element\Select,
Phalcon\Forms\Element\Hidden,
Phalcon\Validation\Validator\PresenceOf;

class Menu_item extends Form {


	public function initialize($model){	
	

		// Main tab
		$name = new Text("name");
		$name->addValidator(new PresenceOf(array(
				'message' => 'name'
		)));
        $this->add($name);
        
		$menu = \Modules\Backend\Models\Menu::find();
		$this->add(new Select('menu_id', $menu, array('using'=>array('id','name'),'class'=>'medium')));

		$status = new Select('status', array('0'=>'Không', '1'=>'Có'));
		$status->setDefault('1');
		$this->add($status);

		// parents menu item
		if($model != null){
			$result = \Modules\Backend\Models\Menu_item::findByMenu_id($model->menu_id);
		} else {
			$result = \Modules\Backend\Models\Menu_item::find();
		}
		
        $system = new \Modules\Library\System();
		$result = $system->convert_object_to_array($result);

		$data = null;
		$system->recursive($result,0,1,$data);
		$record = $system->getListTreeCategory($data,'name');
		$parents = new Select('parents', $record);
		$this->add($parents);

        $type = new Text("type");
        $type->addValidator(new PresenceOf(array(
				'message' => 'type'
		)));
		$this->add($type);
	
		$this->add(new Text("image"));
		$this->add(new Text("position"));

		// Config tab
		$target = new Select('target', array('2'=>'Mặc định', '0'=>'Bình thường', '1'=>'Mở tab mới'));
		$target->setDefault(2);
		$this->add($target);
	
		$this->add(new Select('language', array('vi'=>'Tiếng việt', 'en'=>'Tiếng anh')));

		//params news category
		$result = \Modules\Backend\Models\News_category::find();
		$result = $system->convert_object_to_array($result);
		$data = null;
		$system->recursive($result,0,1,$data);
		$record = $system->getListTreeCategory($data,'title'); 
		$params_category = new Select('params[category][]', $record);
		$params_category->setDefault($system->getParams($model,array('name'=>'category','default'=>0,'mutiple'=>true)));
		$this->add($params_category);

		$params_article = new TextArea('params[article][]');
		$this->add($params_article);
	
		$params_show = new Select('params[show]', array('2'=>'Mặc định', '0'=>'Kênh thông tin - bài viết', '1'=>'Danh sách bài viết'));
		$params_show->setDefault($system->getParams($model, array('name'=>'show', 'default'=>2)));
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
		
		$params_number_title = new Text('params[number_title]',array('class'=>'txt_medium','value'=>"{$system->getParams($model,array('name'=>'number_title','default'=>50))}")); 
		$this->add($params_number_title);

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

		$params_show_paginator = new Select('params[show_paginator]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_show_paginator->setDefault($system->getParams($model,array('name'=>'show_paginator','default'=>2)));
		$this->add($params_show_paginator);
		
		$params_style_paginator = new Select('params[style_paginator]', array('2'=>'Mặc định', '0'=>'Bình thường', '1'=>'Xem thêm'));
		$params_style_paginator->setDefault($system->getParams($model,array('name'=>'style_paginator','default'=>2)));
		$this->add($params_style_paginator);
	}
	
}

/* End of file Menu.php */
/* Location: ./apps/backend/forms/Menu.php */
