$('#password').keyup(function () {
    var pswd = $(this).val();

    if (pswd.length < 6) {
        $('#length').removeClass('text-success').addClass('text-danger');
    } else {
        $('#length').removeClass('text-danger').addClass('text-success');
    }

    if (pswd.match(/[a-z]/)) {
        $('#small').removeClass('text-danger').addClass('text-success');
    } else {
        $('#small').removeClass('text-success').addClass('text-danger');
    }

    if (pswd.match(/[A-Z]/)) {
        $('#big').removeClass('text-danger').addClass('text-success');
    } else {
        $('#big').removeClass('text-success').addClass('text-danger');
    }

    if (pswd.match(/[0-9]/)) {
        $('#number').removeClass('text-danger').addClass('text-success');
    } else {
        $('#number').removeClass('text-success').addClass('text-danger');
    }
});