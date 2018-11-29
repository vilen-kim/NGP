// Отображение модального окна
$("#showDoctor").on('click', function(){
    $("#modalDoctor").modal();
    return false;
});

// Добавление симптомов в блок "опишите самочувствие"
$("#modalDoctor li > a").on('click', function(){
	var text = $("#calldoctor-text").val();
	text += (text.length > 0) ? '\n' : '';
	$("#calldoctor-text").val(text + this.text);
	return false;
})