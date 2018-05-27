$("input[name=typeExecutive]").on("click", function () {
    var type = $(this).val();
    var select = $("select#executive_id");
    if (type == 'organization') {
        select.attr('disabled', true);
    } else {
        select.attr('disabled', false);
        $.ajax({
            url: '/request/get-executive',
            type: 'POST',
            data: {type},
            success: function (data) {
                select.html(data);
            }
        });
    }
});

$('body').on('submit', 'form#author-form', function (event) {
    event.preventDefault();
    var form = $(this);
    if (form.find('.has-error').length) {
        return false;
    }
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function (data) {
            $("#titlePrevAuthors").removeClass('hidden');
            $("#prevAuthors").append(data);
            $(':input', '#author-form')
                    .not(':button, :submit, :reset, :hidden')
                    .val('')
                    .prop('checked', false)
                    .prop('selected', false);
            form.yiiActiveForm('validate', true);
        }
    });
    return false;
});

$('body').on('submit', 'form#letter-form', function (event) {
    event.preventDefault();
    var letterForm = $(this);
    if (letterForm.find('.has-error').length) {
        return false;
    }
    $.post({
        url: letterForm.attr('action'),
        data: $("#letter-form, #author-form").serialize(),
        success: function (data) {
            if (data == false) {
                alert("Укажите автора(ов) обращения");
            }
        }
    });
    return false;
});

$('.getPdf').on('click', function () {
    location = $(this).attr('href');
    return false;
});

$('#dateFilter').on('click', function () {
    date = $("input[name=date]").val();
    location = '/request/share?date=' + date;
    return false;
});