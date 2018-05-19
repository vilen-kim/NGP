$("input[name=requestType]").on("click", function(){
    var url = null;
    if ($(this).val() == 'fromMe'){
        url = '/kabinet/get-requests-from-me';
    } else {
        url = '/kabinet/get-requests-to-me';
    }
    $.ajax({
        url: url,
        type: 'POST',
        success: function(data){
            if (data){
                $("#requests").html(data);
            } else {
                $("#requests").text('У вас пока нет обращений.');
            }
        }
    });
});