<?php
namespace Modules\Frontend\Elements;
use Phalcon\Mvc\User\Component;

class Custom extends Component{

	public function Show($id = 0){

		$element = new \Modules\Frontend\Models\Element;
		$element = $element::findFirstById($id);

		if($element){
			
			require (ELEMENT_PATH.'custom/show.php');
		}
	}
}

/* End of file Shop.php */
/* Location: ./apps/frontend/elements/Shop.php */