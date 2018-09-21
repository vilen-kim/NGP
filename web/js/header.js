// Показ текста при наведении на иконки
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

// Отображение поля для поиска
$("#headerSearch").on('click', function(){
    $("#headerSearchInput").toggle("slow");
    return false;
});

// Отображение модального окна
$("#headerPhone").on('click', function(){
    $("#modalPhone").modal();
    return false;
});