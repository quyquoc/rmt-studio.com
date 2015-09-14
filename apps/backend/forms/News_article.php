<?php

namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\TextArea,
Phalcon\Forms\Element\Select,
Phalcon\Forms\Element\Hidden,
Phalcon\Validation\Validator\PresenceOf;

class News_article extends Form {
	
	public function initialize($model = null){
	
		$system = new \Modules\Library\System();

		// Main tab
		$title = new Text("title");
		$title->addValidator(new PresenceOf());
		$this->add($title);

		$status = new Select('status', array('0'=>'Không', '1'=>'Có'));
		$status->setDefault('1');
		$this->add($status);
	
		// $this->add(new Select('status', array('0'=>'Không', '1'=>'Có')));
		$this->add(new Select('feature', array('0'=>'Không', '1'=>'Có')));
		$this->add(new Text("image"));
		$this->add(new TextArea("description"));
		$this->add(new TextArea("content"));

		// Config tab
		$this->add(new Text("link"));

		$params_show_image = new Select('params[show_image]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_show_image->setDefault($system->getParams($model,array('name'=>'show_image','default'=>2)));
		$this->add($params_show_image);
	
		$params_show_title = new Select('params[show_title]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_show_title->setDefault($system->getParams($model,array('name'=>'show_title','default'=>2)));
		$this->add($params_show_title);

		$params_description = new Select('params[show_description]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_description->setDefault($system->getParams($model,array('name'=>'show_description','default'=>2)));
		$this->add($params_description);

		$params_show_published = new Select('params[show_published]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_show_published->setDefault($system->getParams($model,array('name'=>'show_published','default'=>2)));
		$this->add($params_show_published);
		
		$params_show_hits = new Select('params[show_hits]', array('2'=>'Mặc định', '0'=>'Không', '1'=>'Có'));
		$params_show_hits->setDefault($system->getParams($model,array('name'=>'show_hits','default'=>2)));
		$this->add($params_show_hits);

		$this->add(new Select('url_target', array('2'=>'Mặc định', 'normal'=>'Bình thường','_blank'=>'Mở trang mới')));
		$this->add(new Text("published", array('data-format'=>'yyyy-MM-dd hh:mm:ss', 'value'=>date('d-m-Y H:i:s'))));
		$this->add(new Text("position"));

		// SEO tab
		$this->add(new Text("seo_title"));
		$this->add(new TextArea("metadata"));
		$this->add(new TextArea("keyword"));
		
		$result = \Modules\Backend\Models\News_category::find();
		$system = new \Modules\Library\System();
		$result = $system->convert_object_to_array($result);
		$data 	= null;
		$system->recursive($result,0,1,$data);
		$record = $system->getListTreeCategory($data,"title");
		$category_id = new Select('category_id', $record);
		$this->add($category_id);	
	}

}

/* End of file News_article.php */
/* Location: ./apps/backend/forms/News_article.php */
