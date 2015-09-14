$("ul.tab-row li:first").addClass("active");
$(".tab-group .tab-content:gt(0)").hide();
$("ul.tab-row li").click(function(){
    $("ul.tab-row li").removeClass('active');
    var current_index = $("ul.tab-row li").index(this);
    $("ul.tab-row li:eq("+current_index+")").addClass("active");
    $(".tab-group .tab-content").hide();
    $(".tab-group .tab-content:eq("+current_index+")").fadeIn();
});