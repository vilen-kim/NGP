<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
	'id' => 'forgotpass-form',
	'action' => ['auth/forgot-pass'],
]);

echo '<p>Пожалуйста, укажите Ваш электронный адрес. На него будет отправлено письмо с инструкцией по сбросу пароля.</p>';
echo $form->field($model, 'email');
echo '<div class="form-group">';
echo Html::submitButton('Отправить', ['class' => 'btn btn-primary']);
echo '</div>';

ActiveForm::end();

$this->registerJs('
	$("#forgotpass-form").on("beforeSubmit", function(){
		form = $(this);
		$.ajax({
			url: "' . Url::to(['auth/forgot-pass']) . '",
			type: "POST",
			data: form.serialize(),
			success: function(data) {
				if (data == "OK"){
					location.reload();
				} else {
					form.replaceWith(data);
				}
			}
		})
		return false;
	});
');