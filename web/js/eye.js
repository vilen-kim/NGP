$("#headerEye").click(function(){
    eyeClass = $(this).attr("class");
    if (eyeClass == "toOn"){
        $.ajax({
            url: '/site/eye-on',
            type: 'POST',
            success: function(data){
                if (data){
                    $("#headerEye").removeClass('toOn').addClass('toOff');
                    $("#headerEye a").html("Обычный<br>режим");
                    eyeChange();
                };
            }
        });
    } else {
        $.ajax({
            url: '/site/eye-off',
            type: 'POST',
            data: 'eye-off',
            success: function(data){
                if (data){
                    $("#headerEye").addClass('toOn').removeClass('toOff');
                    location.reload();
                };
            }
        });
    }
    return false;
});


function eyeChange(){
    $("body").css({
        "transition": "1s",
        "background": "black",
        "color": "white",
        "font-size": "16px",
    });
    $("#bottomHolder a").css({
        "transition": "1s",
        "background": "none",
        "color": "cyan",
    });
    $("ul.breadcrumb").css({
       "transition": "1s",
        "background": "black",
        "border": "1px solid gray",
    });
    $("div.callDoctor").css({
        "transition": "1s",
        "background": "black",
        "border": "1px solid gray",
    });
    $("#modalDoctor .modal-header, #modalDoctor .modal-body").css({
        "transition": "1s",
        "background": "black",
        "border": "1px solid gray",
    });
    $("#eyePanel").css({
        "transition": "1s",
        "top": "70px",
    });
}