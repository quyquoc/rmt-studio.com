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

		$this->add(new Text("code"));

		$status = new Select('status', array('0'=>'Không', '1'=>'Có'));
		$status->setDefault('1');
		$this->add($status);
	
		// $this->add(new Select('status', array('0'=>'Không', '1'=>'Có')));
		$this->add(new Select('featured', array('0'=>'Không', '1'=>'Có')));
		$this->add(new Text("image"));
		$this->add(new TextArea("description"));
		$this->add(new TextArea("content"));

		// Config tab
		$this->add(new Text("link"));

		$this->add(new Select('url_target', array('normal'=>'Bình thường','_blank'=>'Mở trang mới')));
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
