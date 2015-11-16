<?php
namespace Modules\Frontend\Elements;
use Phalcon\Mvc\User\Component;

class Menu extends Component{

	public function Show($id = 0){

		$menu = new \Modules\Frontend\Models\Menu;
		$menu = $menu::findFirstByCode($id);

		require (ELEMENTS_PATH.'menu/show.php');
	}

	public function menu($menu_id, $parent, $level){
		
		$menu_item = new \Modules\Frontend\Models\Menu_item;
		$conditions = "menu_id = :id: AND status = 1 AND parents = :parents:";
		$menu_item = $menu_item::find(array(
			"conditions"	=>	$conditions,
			"bind"			=>	array("id"=>$menu_id, 'parents'=>$parent),
			"order"			=>	"position asc"
		));
		
	  	if($level > 0 && count($menu_item) > 0){
	    	echo '<ul>';
	  	}
		foreach ($menu_item as $key => $value) {
			echo "<li>";

		    echo '<a href="'.$this->url->get().$value->link.'">' . $value->name . '</a>';
		    
		    $this->menu($menu_id,$value->id, $level+1);
		    echo "</li>";
		}
		if($level > 0 &&  count($menu_item) > 0){
			echo '</ul>';
		}
	}
}	

/* End of file News.php */
/* Location: ./apps/frontend/elements/News.php */