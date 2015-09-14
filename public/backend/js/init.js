/**
 * 
 */
$(document).ready(function(){
	flash_alert();
	loadPopupArticleMenuItem();
});

// Hàm xử lý hiệu thông báo flash
function flash_alert(){
	// tắt thông báo
	var _obj_error = ".errorMessage";
	$(_obj_error).css({display:"none"});
	$(_obj_error).slideDown("slow");
	
	$(_obj_error).on("click",function(){
		$(this).slideUp("slow");
	});
	setTimeout(function(){
		$(_obj_error).slideUp("slow");
    },5000);
	
	var _obj_success = ".successMessage";
	$(_obj_success).css({display:"none"});
	$(_obj_success).slideDown("slow");
	
	$(_obj_success).on("click",function(){
		$(this).slideUp("slow");
	});
	setTimeout(function(){
		$(_obj_success).slideUp("slow");
    },5000);
}

//
function loadPopupArticleMenuItem(){
	$(".add_article").dblclick( function () {
		$.fancybox({
			width    : 1000,
            maxHeight   : 186,
            fitToView   : false,
            autoSize    : false,
            closeClick  : false,
            openEffect  : 'none',
            closeEffect : 'none',
            padding: 0 ,
            content: "<p>abc</p>" 
	   	});
	});
}