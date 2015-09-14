<?php

namespace Modules\Frontend\Elements;
use Phalcon\Mvc\User\Component;

/**
* Lấy ra các element hiển thị tại vị trí truyền vào
* @param string $posi: vị trí hiển thị của element
*/
class Init extends Component{

	public function load($posi = ''){

		$element = new \Modules\Frontend\Models\Element;

		$conditions 	= 'posi = ?1 and status = 1';

		$parameters 	= array(1=>$posi);
		$list_element	= $element::find(array(
			'conditions'	=> $conditions,
			'bind'			=> $parameters,
			'order' 		=> 'position'
		));
		if(count($list_element)>0){
			foreach ($list_element as $key => $value) {					
				$temp = explode('.', $value->type);
				switch ($temp[0]) {
					case 'news':
						$news = new \Modules\Frontend\Elements\News;
						$news->$temp[1]($value->id);
						break;

					case 'custom':
						$custom = new \Modules\Frontend\Elements\Custom;
						$custom->$temp[1]($value->id);
						break;

					default:
						break;
				}
			}		
		}

	}
}

/* End of file Init.php */
/* Location: ./apps/frontend/elements/Init.php */
