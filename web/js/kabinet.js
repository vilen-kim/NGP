$("a.getAnswer").on("click", function(){
    var id = $(this).data("id");
    $.ajax({
        url: '/kabinet/get-modal-request-answer',
        type: 'POST',
        data: {id},
        success: function(data){
            if (data){
                $("#forModal").html(data);
                $("#modalAnswer").modal();
            }
        }
    })
    return false;
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