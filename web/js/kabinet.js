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

$("a.reSend").on("click", function(){
    var id = $(this).attr("data-id");
    $.ajax({
        url: '/kabinet/get-modal-resend-request',
        type: 'POST',
        data: {id},
        success: function(data){
            if (data){
                $("#forModal").html(data);
                $("#modalResend").modal();
            }
        }
    });
    return false;
})