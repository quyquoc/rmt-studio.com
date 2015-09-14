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

		// Config tab
		$params_type = new Select('params[type]', array('2'=>'Mặc định', '0'=>'Danh sách', '1'=>'Tải tự động'));
		$params_type->setDefault($system->getParams($model, array('name'=>'type', 'default'=>2)));
		$this->add($params_type);
	
		$params_show = new Select('params[show]', array('2'=>'Mặc định', '0'=>'Kênh thông tin - bài viết', '1'=>'Danh sách bài viết'));
		$params_show->setDefault($system->getParams($model, array('name'=>'show', 'default'=>2)));
		$this->add($params_show);
	
		// $this->add(new Text('params[items]'));
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

