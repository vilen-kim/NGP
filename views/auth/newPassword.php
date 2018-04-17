<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="jumbo text-center">
    <div class="page-header"><h1>Создание нового пароля</h1></div>
	<p>Введите новый пароль для учетной записи <b><?= $email ?></b>.</p>

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
			<?php
				$form = ActiveForm::begin([
					'id' => 'auth-newPassword',
					'method' => 'post',
				]);
			?>
			<?= $form->field($model, 'password')->passwordInput() ?>
			<?= $form->field($model, 'passwordRepeat')->passwordInput() ?>
            <div class="form-group">
				<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>