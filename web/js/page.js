function del(id){
    if (confirm("Вы уверены?")) {
        $.ajax({
            url: '/pages/delete',
            type: 'POST',
            data: {id},
            success: function(data){
                if (data){
                    $("tr[data-key="+id+"]").hide(300);
                }
            }
        });
    }
};



$("#toggleSearchOnPage").on("click", function(){
    $("div.searchOnPage").toggle("slow");
    return false;
});


var highText = null;
var count = 0;
var allCount = 0;
var span = null;

$("#searchOnPage").on("click", function(){
    var text = $("input[name=search]").val();
    if ((text != highText) && text){
        highText = text;
        $("div.container").unhighlight();
        $("div.container").highlight(text);
        allCount = $("span.highlight").length;
        count = 0;
        if (!allCount)
            return false;
    }

    if (++count <= allCount){
        if (span)
            span.before(span.text()).remove();    
        $("span.count").text(count + "/" + allCount);
        $(this).text("Найти далее");
        span = $("span.highlight:first");
        span.css("background", "red");
        var top = span.offset();
        $('html, body').animate({ scrollTop: span.offset().top - 100}, 500);
        if (count == allCount){
            $(this).text("Новый поиск");
            highText = null;
        }
    }

    return false;
})