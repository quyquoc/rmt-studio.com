<?php
namespace Modules\Frontend\Elements;
use Phalcon\Mvc\User\Component;

class Element extends Component{

	public function Image_slick($limit = "5", $featured = null){

		$tbl_image_album 	= new \Modules\Frontend\Models\Image_album();

		$conditions 		= "status = 1";

		if(isset($featured) && !empty($featured)){
			$conditions 	.= " AND featured = {$featured}";
		}

		$list_item			= $tbl_image_album->find(array(
			'conditions'	=> $conditions,
			'order'			=> 'position ASC',
			'limit'			=> $limit
		));

		require (ELEMENTS_PATH.'image/slick.php');
	}
}	

/* End of file Element.php */
/* Location: ./apps/frontend/elements/Element.php */