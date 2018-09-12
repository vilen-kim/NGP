$("#headerEye.toOn").click(function(){
    $.ajax({
        url: '/site/eye-on',
        type: 'POST',
        data: 'eye-on',
        success: function(data){
            if (data){
                $("#headerEye").addClass('toOff').removeClass('toOn');
                location.reload();
            };
        }
    });
    return false;
});

$("#headerEye.toOff").click(function(){
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
    return false;
});