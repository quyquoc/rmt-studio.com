<?php
	namespace Modules\Library;
	class Paginator {

		private $page;
		private $controller;

		public function __construct($page,$controller){
			$this->page = $page;
			$this->controller = $controller;
		}

		/**
		 *	Hàm trả về link của phân trang
		 *	@return string
		 */
		public function getLink($column_search = null){
			if($this->page->total_pages > 1){
				
				$total = $this->page->total_pages;
				$constant = new \Modules\Library\Constant();
				$subtract = $this->page->current - $constant::LIMIT_PAGE;
				$addition = $this->page->current + $constant::LIMIT_PAGE;
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
				
				$limit = null;
				if(isset($_GET['limit'])){
					$limit = '&limit='.(int) $_GET['limit'];	
				}
				$search = null;
				if(isset($_GET[$column_search])){
					$search = "&{$column_search}=".(string)$_GET[$column_search];	
				}
				$str = '';
				$str .= '<ul class="paging">';
					$str .= '<li class="first">'.\Phalcon\Tag::linkTo(array("admin/{$this->controller}/index?page=1{$limit}{$search}", 'Trang đầu','class'=>'page gradient')) .'</li>';
					$str .= '<li class="previous">'.\Phalcon\Tag::linkTo(array("admin/{$this->controller}/index?page={$this->page->before}{$limit}{$search}", 'Trang trước','class'=>'page gradient')) .'</li>';
					for($i=$start;$i<=$end;$i++){
						if($i != $this->page->current){
							$str .= '<li>'.\Phalcon\Tag::linkTo(array("admin/{$this->controller}/index?page={$i}{$limit}{$search}","{$i}",'class'=>'page gradient')) .'</li>';
						} else {
							$str .= '<li><span class="page active">'.$i.'</span></li>';
						}
					}
					$str .= '<li class="next">'.\Phalcon\Tag::linkTo(array("admin/{$this->controller}/index?page={$this->page->next}{$limit}{$search}", 'Trang tiếp','class'=>'page gradient')) .'</li>';
					$str .= '<li class="last">'.\Phalcon\Tag::linkTo(array("admin/{$this->controller}/index?page={$this->page->last}{$limit}{$search}", 'Trang cuối','class'=>'page gradient')) .'</li>';
				$str .= "</ul>";

				return $str;
			}
			return null;
		}
	}
