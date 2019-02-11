$("a.archive").on('click', function(){
    id = $(this).data('id');
    $.ajax({
        url: '/orders/archive',
        type: 'POST',
        data: {id},
        success: function(data){
            if (data == 'ok'){
                $("tr[data-key="+id+"]").hide(300);
            }
        }
    });
    return false;
});
