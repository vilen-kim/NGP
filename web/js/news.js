$("#loadNews").on("click", function(){
    var loaded = $("div.newsWidget").length;
    $.ajax({
        url: '/site/load-news',
        type: 'POST',
        data: {loaded},
        success: function(data){
            if (data == false){
                $("#loadNews > span").removeClass('text-primary');
                $("#loadNews > span").addClass('text-danger');
            } else {
                $("#news > div").append(data);
            }
        }
    });
    return false;
});