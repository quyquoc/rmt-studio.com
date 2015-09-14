$(document).ready(function(){
	
	$('.icn_delete').click(function(e){
		e.preventDefault();
		var elem = $(this).closest('.icn_delete');
		elem.parent().parent().addClass('flash_delete');
		var title = elem.attr('title');
		$.confirm({
			'title'		: 'Xác nhận xóa dữ liệu',
			'message'	: 'Bạn muốn xóa '+title+'?',
			'buttons'	: {
				'Đồng ý'	: {
					'class'	: 'blue',
					'action': function(){
						var id,link;
						id = elem.attr('ref');
						link = elem.attr('link');
						window.location=link+id;
					}
				},
				'Không'	: {
					'class'	: 'gray',
					'action': function(){
						elem.parent().parent().removeClass('flash_delete');
					}
				}
			}
		});
		
	});

	// confirm xóa quyền ở group-privilege
	$('.gp_delete').click(function(e){
		e.preventDefault();

		var elem = $(this).closest('.gp_delete');
		elem.parent().parent().addClass('flash_delete');
		var title = elem.attr('title');
		$.confirm({
			'title'		: 'Xác nhận xóa dữ liệu',
			'message'	: 'Bạn muốn xóa '+title+'?',
			'buttons'	: {
				'Đồng ý'	: {
					'class'	: 'blue',
					'action': function(){
						var link;
						link = elem.attr('href');
						window.location=link;
					}
				},
				'Không'	: {
					'class'	: 'gray',
					'action': function(){
						elem.parent().parent().removeClass('flash_delete');
					}
				}
			}
		});
		
	});
	
});