<?php
	namespace Modules\Library;
	/**
	 *	Class trả về string dạng html
	 */
	class Html {

		public function __construct(){}
		
		/**
		 *	Hàm lấy string html get số dòng data
		 */
		public function getLimitRecord($search = null,$limit = null){
			
			$html  = '';
			$html .= '<select ref="'.$search.'" onchange="get_limit_row(this);">';
			$html .=	'<option  value="5"';
			$html .=	$limit == 5 || $limit == null ? 'selected':'';
			$html .= 	'>5</option>';
			
			$html .=	'<option  value="10"';
			$html .=	$limit == 10 ? 'selected':'';
			$html .=	'>10</option>';
			
			$html .=	'<option  value="15"';
			$html .=	$limit == 15 ? 'selected':'';
			$html .=	'>15</option>';
			
			$html .=	'<option  value="20"';
			$html .=	$limit == 20 ? 'selected':'';
			$html .=	'>20</option>';
			
			$html .=	'<option  value="50"';
			$html .=	$limit == 50 ? 'selected':'';
			$html .=	'>50</option>';

			$html .=	'<option  value="100"';
			$html .=	$limit == 100 ? 'selected':'';
			$html .=	'>100</option>';

			$html .= '</select>';
			return $html;
		}
	}