<?php

namespace Modules\Library;

class Plugin {

	public function __construct(){}

	/**
     * 	Hàm trả về class trạng thái
     *	@param 	$status [integer]
     *	@return string
     */
    public function getStatusDetail($status = 0){
        if ($status == '1') {
            return 'icn_active';
        }
        return 'icn_no_active';
    }

    /**
	 *	Chuyển chuỗi thành code
	 *	@param $name [string]
	 *	@return $str
     */
    public function alias_name($str){
		$array_search = array("á","à","ả","ã","ạ","ắ","ằ","ẳ","ẵ","ặ","ấ","ầ","ẩ","ẫ","ậ","é","è","ẻ","ẽ","ẹ","ế","ề","ể","ễ","ệ","í","ì","ỉ","ĩ","ị","ó","ò","ỏ","õ","ọ","ố","ồ","ổ","ỗ","ộ","ớ","ờ","ở","ỡ","ợ","ú","ù","ủ","ũ","ụ","ứ","ừ","ử","ữ","ự","ý","ỳ","ỷ","ỹ","ỵ","ă","â","đ","ê","ô","ơ","ư","Á","À","Ả","Ã","Ạ","Ắ","Ằ","Ẳ","Ẵ","Ặ","Ấ","Ầ","Ẩ","Ẫ","Ậ","É","È","Ẻ","Ẽ","Ẹ","Ế","Ề","Ể","Ễ","Ệ","Í","Ì","Ỉ","Ĩ","Ị","Ó","Ò","Ỏ","Õ","Ọ","Ố","Ồ","Ổ","Ỗ","Ộ","Ớ","Ờ","Ở","Ỡ","Ợ","Ú","Ù","Ủ","Ũ","Ụ","Ứ","Ừ","Ử","Ữ","Ự","Ý","Ỳ","Ỷ","Ỹ","Ỵ","Ă","Â","Đ","Ê","Ô","Ơ","Ư"," ", "--", ":", "%20");
		$array_replace = array("a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","e","e","e","e","e","e","e","e","e","e","i","i","i","i","i","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","u","u","u","u","u","u","u","u","u","u","y","y","y","y","y","a","a","d","e","o","o","u","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","e","e","e","e","e","e","e","e","e","e","i","i","i","i","i","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","u","u","u","u","u","u","u","u","u","u","y","y","y","y","y","a","a","d","e","o","o","u","-", "-", "-", "-");
		$str = strtolower(str_replace($array_search,$array_replace,$str));
		$str = preg_replace('/[^a-z 0-9~%.:_\-]+/', '', $str);
		return str_replace('--','-',$str);
	}

	/** 
	 *	Chuyển chuỗi thành code có kiểm tra trong table trường hợp trùng alias_name
	 *	@param $str [string]
	 *	@param $table_name [object]
	 *	@param $id [integer]
	 */
	public function create_code(&$str, $table_name, $id = null){

        $str 	= $this->alias_name($str);
       	$model 	= "\Modules\Backend\Models\\".$table_name;

       	if(isset($id) && !empty($id)){

       		$conditions = "code = :code: AND id != :id:";
       		$query = array("conditions" => $conditions, "bind" => array("code" => $str, "id" => $id));
       	} else {

       		$conditions = "code = :code:";
       		$query = array("conditions" => $conditions, "bind" => array("code" => $str));
       	}

        $item = $model::findFirst($query);
        
        if(isset($item) && !empty($item)){ 

        	$str = $str.'-'.rand();
        	$this->create_code($str, $table_name, $id);
        } else {

        	return $str;
        }
	}

	/**
	 *	Hàm trả về đường dẫn theo title
	 *	@param $value [object]
	 *	@return $url [string]
	 */
	public function getLinkDetail($value = null, $type = null){
		$url  = $this->alias_name($value->title);

		switch ($type) {
			case 'news':
				$url .=	"-a".$value->id;
				break;
			case 'shop':
				$url .=	"-p".$value->id;
				break;		
			case 'purchase':
				$url .=	"-pu".$value->id;
				break;			
			default:
				$url .=	"-a".$value->id;
				break;
		}
		return $url;
	}

	/**
	 *	Hàm lấy đường dẫn phân trang của frontend
	 * 	@param $controller [string] news->tin-tuc
	 *	@param $category [string]	category->the-thao
	 *	@param $page [string]
	 */
	public function getPaginator($option,$page){
		if($page->total_pages > 1){
			$menu_code = null;
			if($option['menu_code'] == null){
				$menu_code = null;
			} else {
				$menu_code = '/'.$option['menu_code'];
			}
			switch ($option['style_paginator']) {

				case '1': // Xem them

					$str  = '';
					$str .= '<div class="pagination><ul class="paging">';
					$str .= '<li class="next">'.\Phalcon\Tag::linkTo(array("{$option['controller']}{$menu_code}?page={$page->next}", 'Xem thêm','class'=>'page gradient')) .'</li>';
					$str .= "</ul></div>";

					return $str;

				default: // Binh thuong
					$total = $page->total_pages;
					
					$subtract = $page->current - 3;
					$addition = $page->current + 3;
					if($subtract > 0){
						$start = $subtract;
					} else {
						$start = 1;
					}
					if($addition <= $total){
						$end = $addition;
					} else {
						$end = $total;
					}

					$str  = '<div class="pagination">';
					$str .= '<ul class="paging">';
						$str .= '<li class="first">'.\Phalcon\Tag::linkTo(array("{$option['controller']}{$menu_code}?page=1", 'Trang đầu','class'=>'page gradient')) .'</li>';
						$str .= '<li class="previous">'.\Phalcon\Tag::linkTo(array("{$option['controller']}{$menu_code}?page={$page->before}", 'Trang trước','class'=>'page gradient')) .'</li>';
						for($i=$start;$i<=$end;$i++){
							if($i != $page->current){
								$str .= '<li>'.\Phalcon\Tag::linkTo(array("{$option['controller']}{$menu_code}?page={$i}","{$i}",'class'=>'page gradient')) .'</li>';
							} else {
								$str .= '<li><span class="page active">'.$i.'</span></li>';
							}
						}
						$str .= '<li class="next">'.\Phalcon\Tag::linkTo(array("{$option['controller']}{$menu_code}?page={$page->next}", 'Trang tiếp','class'=>'page gradient')) .'</li>';
						$str .= '<li class="last">'.\Phalcon\Tag::linkTo(array("{$option['controller']}{$menu_code}?page={$page->last}", 'Trang cuối','class'=>'page gradient')) .'</li>';
					$str .= "</ul></div>";

					return $str;
			}
		}
		return null;
	}

	/**
	 *	Cắt chuỗi
	 * 	@param $controller [string] news->tin-tuc
	 *	@param $category [string]	category->the-thao
	 *	@param $page [string]
	 */
	public function getCutString($string, $number, $option = null){

		if($option == null){
			//Lược bỏ các tags HTML
			$string = strip_tags($string);
			
			if(strlen($string) > $number) {
				$stringCut = substr($string, 0, $number);
				
				//Tránh trường hợp cắt dang dở như "nội d..."
				$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
			}	
		}		
		
		return $string;
	}

	/**
	 *	Lấy các phần tử con của menu_item, lấy theo giá trị parent
	 *	@param $parent [integer] id của phần tử cha, default = 0
	 *	@param $level [integer]	mức muốn lấy, default = 0
	 *	@param $column [string] giá trị cần lấy , default = id
	 * 	@param &$data [array] đây là biến dạng tham trị, sẽ trả về biến data
	 */
	public function getMenuItemChildren($parent = 0,$level = 0,$column = 'id',&$data = null){
		
		$menu_item = new \Modules\Frontend\Models\Menu_item;
		$conditions = "status = 1 AND parents = :parents:";
		$menu_item = $menu_item::find(array(
			"conditions"	=>	$conditions,
			"bind"			=>	array('parents'=>$parent),
			"order"			=>	"position asc"
		));

		foreach ($menu_item as $key => $value) {
			$data[] = $value->$column;
		    $this->getMenuItemChildren($value->id, $level+1,$column,$data);
		}	
	}
	
	/** 
	 *	Lấy toàn bộ childCategoryID con từ 1 id cha arrCategory
	 *	@param $name_table [string]
	 *	@param $parents [integer]
	 *	@param $parents [object]
	 *	@param $option [array]
	 */
	public function get_child_category_id($name_table = null, $parents = null, &$data = null, $option = null){
		
		$table 		= "\Modules\Frontend\Models\\".$name_table;
		$conditions = "status = 1 AND parents = :parents:";
		$result 	= $table::find(array(
			"conditions"	=>	$conditions,
			"bind"			=>	array('parents'=>$parents),
			"columns"		=> 'id',
		));
		// echo '<pre>';print_r($result->toArray());die;

		if(count($result) > 0){
			foreach ($result as $key => $value) {
				$data[] = $value->id;
				$this->get_child_category_id($name_table, $value->id, $data, $option);
			}	
		}
		$data[] = $parents;	
	}

	/** 
	 *	Lấy nội dung text và thay thế các chuỗi ký tự đặc biệt
	 *	@param $content [string]
	 *	@param $option [array]
	 */
	public function replace_string($content, $option = null){
		if($option == null){
			$str = str_replace('\"', '"', $content);
			$str = str_replace("\'", "'", $str);			
		}		
		
		return $str;
	}

	/**
 	*	CÁC HÀM KHÔNG CÒN SỬ DỤNG
	*/

		/**
		 *	Hàm lấy ra từng giá trị của params
		 *	@param $params [string]
		 *	@return array
		 */
		public function getItemParam($params){
			// $data = array();
			// $params_item = explode(";",$params);
			// foreach ($params_item as $key => $value) {
			// 	if(!empty($value)){
			// 		$exp = explode("=", $value);
			// 		$data[$exp[0]] = $exp[1];
			// 	}
			// }
			// return $data;
		}
}

/* End of file Plugin.php */
/* Location: ./apps/library/Plugin.php */