$("input[name=typeWhom]").on("click", function(){
    var type = $(this).val();
    var select = $("select[name='whom_id']");
    if (type == 'organization'){
        select.attr('disabled', true);
    } else {
        select.attr('disabled', false);
        $.ajax({
            url: '/request/get-whom',
            type: 'POST',
            data: {type},
            success: function(data){
                select.html(data);
            }
        });
    }
});

$('body').on('submit', 'form#author-form', function(event) {
    event.preventDefault();
    var form = $(this);
    if (form.find('.has-error').length) {
        return false;
    }
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function(data){
            $("#titlePrevAuthors").removeClass('hidden');
            $("#prevAuthors").append(data);
            form[0].reset();
        }
    });
    return false;
});