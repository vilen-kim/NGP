$("#eyePanel #fontSizeDown").on("click", function(){
    fontSize = $("body").css("font-size");
    $("body").css("font-size", parseInt(fontSize) - 1 + "px");
    return false;
})



$("#eyePanel #fontSizeUp").on("click", function(){
    fontSize = $("body").css("font-size");
    $("body").css("font-size", parseInt(fontSize) + 1 + "px");
    return false;
})



$("#eyePanel #whiteOnBlack").on("click", function(){
    $("body").css("color", "white");
    $("body").css("background", "black");
    return false;
})



$("#eyePanel #whiteOnBrown").on("click", function(){
    $("body").css("color", "white");
    $("body").css("background", "brown");
    return false;
})



$("#eyePanel #whiteOnGray").on("click", function(){
    $("body").css("color", "white");
    $("body").css("background", "gray");
    return false;
})



$("#eyePanel #blackOnWhite").on("click", function(){
    $("body").css("color", "black");
    $("body").css("background", "white");
    return false;
})



$("#eyePanel #blackOnBrown").on("click", function(){
    $("body").css("color", "black");
    $("body").css("background", "brown");
    return false;
})



$("#eyePanel #blackOnGray").on("click", function(){
    $("body").css("color", "black");
    $("body").css("background", "gray");
    return false;
})
