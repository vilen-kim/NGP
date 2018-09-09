$("div.showText").hover(
    function(){
        $(this).children("img").css("opacity", "0.2");
        $(this).children("a").show();
    },
    function(){
        $(this).children("img").css("opacity", "1.0");
        $(this).children("a").hide();

    }
);

$("#headerSearch").on('click', function(){
    $("#headerSearchInput").toggle("slow");
    return false;
});

$("#headerPhone").on('click', function(){
    $("#modalPhone").modal();
    return false;
});