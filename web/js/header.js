var width = $("header > div:nth-child(2)").width();
var searchImgW = $("#searchImg").width();
$("#searchText").css("width", width - searchImgW - 20);



$("#menuLink").on("click", function () {
    $("#modalMenu").modal();
    return false;
});