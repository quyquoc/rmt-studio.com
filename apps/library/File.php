<?php
	namespace Modules\Library;
	class File {

		public function __construct(){}

		/**
		 *	Hàm upload file
		 *	@param $file $_FILE
		 *	@param $options array 
		 *  					(
		 *							'type_file'  -> Loại file cho phép upload (array)
		 *							'url_folder' -> Đường dẫn chưa file,tính từ public trở vào (string)
		 *							'size_file'  -> Giới hạn dung lượng file up lên
		 *  					)
		 *	@param $remove -> nếu khác null thì sẽ xóa file theo giá trị truyền vào, thực hiện khi up thành công
		 *	@return array('status','messenge') -> status = 0 thành công
		 */
		public function upload_file($file = null,$options = null,$remove = null){
			$result = array();
			if(!empty($file) && !empty($options)){
				// Xử lý upload file
				if($file['name'] != NULL){ // Đã chọn file
			    	if(in_array($file['type'], $options['type_file'])){ 
			    		$bytes = number_format($file['size'] / 1024,0);
			    		$access = 0;
			    		if(!isset($options['size_file'])){  // dung lượng cho phép mặc định là 2048kb
			    			$access = 2048;
			    		} else {
			    			$access = $options['size_file'];
			    		}
				    	if($bytes <= $access){ // File size nhỏ hơn 2048 thì cho upload
				    		// file hợp lệ, tiến hành upload
			                $path = ROOT_UPLOAD_DIR.$options['url_folder']; // file sẽ lưu vào thư mục data
			                $tmp_name = $file['tmp_name']; 
			                // đổi tên file
			                $temp = explode(".",basename($file["name"]));
							$newfilename = md5(uniqid(microtime(true))). '.' . end($temp);
			                // Upload file
			                if(!file_exists($path.$newfilename)){
			                	if(move_uploaded_file($tmp_name,$path.$newfilename)){
				                	$result['status']   = 0;
									$result['messenge'] = $options['url_folder'].$newfilename;
									if($remove != null){ // Xóa file cũ
										$file_old = ROOT_UPLOAD_DIR.$remove;
										if(file_exists($file_old)){
											unlink($file_old);
										}
									}
				                } else {
				                	$result['status']   = 1;
									$result['messenge'] = 'Lỗi hệ thống';
				                }
			                } else { 
				                $result['status']   = 2;
								$result['messenge'] = 'Trùng tên file';
			                }
				    	} else {
				      		$result['status']   = 3;
							$result['messenge'] = 'Dung lượng upload quá giới hạn ( <= '.$access.')';
				    	}
				  	}else{
				      	$result['status']   = 4;
						$result['messenge'] = 'File upload không hợp lệ';
				  	}
			    } else {
			    	$result['status']   = 5;
					$result['messenge'] = 'Chưa chọn file';
			    }
			} else {
				$result['status']   = 6;
				$result['messenge'] = 'File rỗng hoặc tham số options rỗng';
			}
			return $result; 
		}
	}