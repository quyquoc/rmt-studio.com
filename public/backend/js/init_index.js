
// Hàm js để chọn tất cả cả checkbox
function togglecheckboxes(master,group){ 
	var cbarray = document.getElementsByClassName(group); 
	for(var i = 0; i < cbarray.length; i++){
	 	var cb = document.getElementById(cbarray[i].id); 
	 	cb.checked = master.checked; 
	} 
}

// Hàm lấy giá trị limit ở ô tùy chọn số dòng
function get_limit_row(_obj){
	var limit = $(_obj).val();
	var search = $(_obj).attr("ref");
	window.location.href = "?limit="+limit+search;
}
