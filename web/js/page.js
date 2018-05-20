function del(id){
    if (confirm("Вы уверены?")) {
        $.ajax({
            url: '/pages/delete',
            type: 'POST',
            data: {id},
            success: function(data){
                if (data){
                    $("tr[data-key="+id+"]").hide(300);
                }
            }
        });
    }
};
