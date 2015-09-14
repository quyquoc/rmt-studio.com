// lấy ckfinder ở ô input image
$(".fileBrowse").on("click", function () { 
    var finder = new CKFinder(); 
    var target = $(this).attr('data-target');
    finder.selectActionFunction = function (fileUrl, data) {
        document.getElementById(target).value = fileUrl;
    }
    
    finder.popup();
});


