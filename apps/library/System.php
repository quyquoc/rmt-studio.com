<?php
	namespace Modules\Library;
	
	class System {
		private $order = null; // biến sử dụng cho hàm setIconPosition
		
		public function __construct($order = null){
			$this->order = $order;
		}

		/**
		 *	Hàm đệ quy sắp xếp lại category	theo đúng thứ tự
		 *	@param $sourceArr array
		 *	@param $parents  int (0)
		 *	@param $level int (1)
		 *	@param vs @return $resultArr (tham biến) 
		 */
		public function recursive($sourceArr, $parents = 0, $level = 1, &$resultArr){
			if(count($sourceArr) > 0){
				foreach($sourceArr as $key => $value){
					if($value->parents == $parents){
						$value->level = $level;
						$resultArr[] = $value;
						$newParents = $value->id;
						unset($sourceArr[$key]);
						$this->recursive($sourceArr, $newParents, $level + 1, $resultArr);	
					}
				}
			}
		}

		/**
		 *	Hàm liệt kê danh mục theo select
		 *	@param $array array
		 *	@return array tree
		 */
		public function getListTreeCategory($array = array(),$title = null){
			$record = array();
			$record[0]	=	"&nbsp Danh mục gốc";
			if(is_array($array) && count($array) > 0){
				foreach ($array as $key => $value) {
					$space = "&nbsp";
					if($value->level > 1){
						for ($i=1; $i <= $value->level; $i++) { 
							$space .= ";&nbsp;&nbsp;&nbsp";
						}
						$record[$value->id] = $space." - ".$value->$title;
					} else {
						$record[$value->id] = $space." ".$value->$title;
					}
				}
				return $record;
			}
			return $record;
		}

		/**
		 *	Hàm chuyển dữ liệu từ object sang array
		 *	@param $object object 
		 *	@return array
		 */
		public function convert_object_to_array($object = null){
			if($object != null && count($object) > 0){
				$array = array();
				foreach ($object as $key => $value) {
					$array[] = $value;
				}
				return $array;
			}
			return null;
		}

		/**
	     *  Hàm lấy icon để biết đang sắp xếp theo cột nào và kiểu sắp xếp là gì
	     *  @param $column_current
	     */
	    public function getIconPosition($column_current = null){
	    	$str  = "icn_order";
	        if(isset($_GET['column']) && isset($_GET['order'])){
	            if($column_current == $_GET['column']){
	            	$active = $_GET['order'];
	            	$class = $active == "desc" ? "desc" : "asc";
	            	$str  = "icn_order {$class}";
	            	return $str;
	            }
	            return $str;
	        } else if(!empty($this->order)) {
	        	$exe = explode(" ",$this->order);
	        	if(isset($exe[0]) && $exe[0] == $column_current){
	        		$active = $exe[1];
	            	$class = $active == "desc" ? "desc" : "asc";
	            	$str  = "icn_order {$class}";
	            	return $str;
	        	}
	        	return $str;
	        }
	        return $str; 
	    }

	    /**
		 *	Hàm set selected, sử dụng ở form
		 *	@param $model [object]
		 *	@param $option [array]
		 *	@return string
	     */
	    public function getParams($model = null, $option = null){ 
			if(isset($_POST['params'])){
				$model->params = $_POST['params'];
			}  
			$pa = explode(";", $model->params);
			foreach ($pa as $key => $value) {
				$a = explode("=", $value);
				if($model == null){
					if(isset($option['default'])){
						$params[$option['name']] = $option['default'];
					} else {
						$params[$option['name']] = 0;
					}
				} else { 		
					if($a[0] == $option['name']){
						if(isset($option['mutiple'])){
							$id = explode(",", $a[1]);
							return $id;
						}
					}
					$params[$a[0]] = $a[1];
				}
			}
			
			return $params[$option['name']];
		}

		/** 
		 *	Hàm sinh mã code tương ứng với name hoặc title
		 *	@param $code [string]
		 *	@param $object [object]
		 *	@param $id [integer]
		 */
		public function getCode(&$code, $object,$id = null){
			$plugin = new \Modules\Library\Plugin;
            $code = $plugin->alias_name($code);
           	$model = "\Modules\Backend\Models\\".$object;
           	if($id != null){
           		$conditions = "code = :code: AND id != :id:";
           		$query = array("conditions" => $conditions,"bind" => array("code" => $code,"id" => $id));
           	} else {
           		$conditions = "code = :code:";
           		$query = array("conditions" => $conditions,"bind" => array("code" => $code));
           	}

            $item = $model::findFirst($query);
            if($item){ 
            	$code = $code.rand();
            	$this->getCode($code, $object);
            } else {
            	return $code;
            }
		}
		
	}