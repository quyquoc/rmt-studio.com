// lấy ckfinder ở ô input image
function setImage(_obj){
	var finder = new CKFinder(); 
    var target = $(_obj).attr('data-target');
    finder.selectActionFunction = function (fileUrl, data) {
    	$('.data_image').append('<div class="item"><img src="'+fileUrl+'" /><span ref="'+item+'" onClick="delete_image(this)"></span></div>');
    	sourc[item] = fileUrl;
        document.getElementById(target).value = sourc;
        item++;
    }
    
    finder.popup();
}


function delete_image(_obj){
	var i = parseInt($(_obj).attr("ref")); 
	sourc.splice(i,1,"");
	document.getElementById("select_image").value = sourc;
	$(_obj).parent().remove();
}



