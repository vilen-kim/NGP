$("#eyePanel #fontSizeDown").on("click", function(){
    fontSize = parseInt($("body").css("font-size")) - 1;
    $("body").css({
        "transition": "1s",
        "font-size": fontSize + "px",
    });
    $.post("/site/eye-change", {fontSize: fontSize + "px"});
    return false;
})



$("#eyePanel #fontSizeUp").on("click", function(){
    fontSize = parseInt($("body").css("font-size")) + 1;
    $("body").css({
        "transition": "1s",
        "font-size": fontSize + "px",
    });
    $.post("/site/eye-change", {fontSize: fontSize + "px"});
    return false;
})



$("#eyePanel #whiteOnBlack").on("click", function(){
    $("#bottomHolder a").css({
        "transition": "1s",
        "background": "none",
        "color": "cyan",
    });
    $("body, ul.breadcrumb, div.callDoctor, #modalDoctor .modal-header, #modalDoctor .modal-body").css({
        "transition": "1s",
        "color": "white",
        "background": "black",
    });
    $.post("/site/eye-change", {background: "black", color: "white", link: "cyan"});
    return false;
})



$("#eyePanel #whiteOnBrown").on("click", function(){
    $("#bottomHolder a").css({
        "transition": "1s",
        "background": "none",
        "color": "black",
    });
    $("body, ul.breadcrumb, div.callDoctor, #modalDoctor .modal-header, #modalDoctor .modal-body").css({
        "transition": "1s",
        "color": "white",
        "background": "brown",
    });
    $.post("/site/eye-change", {background: "brown", color: "white", link: "black"});
    return false;
})



$("#eyePanel #whiteOnGray").on("click", function(){
    $("#bottomHolder a").css({
        "transition": "1s",
        "background": "none",
        "color": "black",
    });
    $("body, ul.breadcrumb, div.callDoctor, #modalDoctor .modal-header, #modalDoctor .modal-body").css({
        "transition": "1s",
        "color": "white",
        "background": "gray",
    });
    $.post("/site/eye-change", {background: "gray", color: "white", link: "black"});
    return false;
})



$("#eyePanel #blackOnWhite").on("click", function(){
    $("#bottomHolder a").css({
        "transition": "1s",
        "background": "none",
        "color": "darkblue",
    });
    $("body, ul.breadcrumb, div.callDoctor, #modalDoctor .modal-header, #modalDoctor .modal-body").css({
        "transition": "1s",
        "color": "black",
        "background": "white",
    });
    $.post("/site/eye-change", {background: "white", color: "black", link: "darkblue"});
    return false;
})



$("#eyePanel #blackOnBrown").on("click", function(){
    $("#bottomHolder a").css({
        "transition": "1s",
        "background": "none",
        "color": "cyan",
    });
    $("body, ul.breadcrumb, div.callDoctor, #modalDoctor .modal-header, #modalDoctor .modal-body").css({
        "transition": "1s",
        "color": "black",
        "background": "brown",
    });
    $.post("/site/eye-change", {background: "brown", color: "black", link: "cyan"});
    return false;
})



$("#eyePanel #blackOnGray").on("click", function(){
    $("#bottomHolder a").css({
        "transition": "1s",
        "background": "none",
        "color": "darkblue",
    });
    $("body, ul.breadcrumb, div.callDoctor, #modalDoctor .modal-header, #modalDoctor .modal-body").css({
        "transition": "1s",
        "color": "black",
        "background": "gray",
    });
    $.post("/site/eye-change", {background: "gray", color: "black", link: "darkblue"});
    return false;
})
