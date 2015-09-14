<?php
namespace Modules\Frontend\Elements;
use Phalcon\Mvc\User\Component;

class News extends Component{

	public function Show($id = 0){

		$element = new \Modules\Frontend\Models\Element;
		$element = $element::findFirstById($id);

		if($element){
			$params = explode(';', $element->params);
			foreach ($params as $key=>$val){
				$tmp = explode('=', $val);
				//tach chuoi category ve mang category
				// SE XU LY SAU NHA.....
				// if($tmp[0] == 'category'){				
				// 	//cac phan tu trong chuoi category duoc cach nhau boi dau '-'
				// 	$tmp1 = explode('-', $tmp[1]);
				// 	foreach ($tmp1 as $key_1=>$val_1){
				// 		$arrCat2 = explode('>', $val_1);
				// 		$newArray['params'][$tmp2[0]][$arrCat2[0]] = $arrCat2[1];
				// 	}
				// }else{
					if(isset($tmp[1])) {
						$arrParams[$tmp[0]] = $tmp[1];
					}
				// }
			}
			$element->params = $arrParams;
			// echo '<pre>';print_r($element->params);

			$conditions = "category_id IN (:category:)";
	        $query =  array(
				    'conditions' 	=> $conditions,
				    'bind' 			=> array('category' => $arrParams['category']),
				    'limit' 		=> $arrParams['items'],
			); 

			$articles = new \Modules\Frontend\Models\News_article;
			$articles = $articles::find($query);
		}
		
		require (ELEMENT_PATH.'news/show.php');
	}

	public function Search($id = 0){

		$element = new \Modules\Frontend\Models\Element;
		$element = $element::findFirstById($id);

		# code here...
		
		require (ELEMENT_PATH.'news/search.php');
	}
}	

/* End of file News.php */
/* Location: ./apps/frontend/elements/News.php */