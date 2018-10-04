$("a.getInfo").on("click", function(){
    var id = $(this).data("id");
    $.ajax({
        url: '/call-doctor/get-modal-info',
        type: 'POST',
        data: {id},
        success: function(data){
            if (data){
                $("#forModal").html(data);
                $("#modalCallInfo").modal();
            }
        }
    })
    return false;
});



$("a.getComment").on("click", function(){
    var id = $(this).data("id");
    $.ajax({
        url: '/call-doctor/get-modal-comment',
        type: 'POST',
        data: {id},
        success: function(data){
            if (data){
                $("#forModal").html(data);
                $("#modalCallComment").modal();
            }
        }
    })
    return false;
});