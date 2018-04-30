<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

app\assets\AuthAsset::register($this);
$this->title = 'Восстановление пароля';
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="row">
    <div class="col-md-6 col-md-offset-3 border">
        <p>Введите новый пароль для учетной записи <b><?= $email ?></b>:</p>
        
        <?php $form = ActiveForm::begin(['id' => 'auth-newPassword']); ?>
        <?= $form->field($model, 'password')->passwordInput(['id' => 'password']) ?>
        <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn scale', 'style' => 'background: #ffda44; color: black']) ?>
        <?php ActiveForm::end(); ?>
        
    </div>
    <div class="col-md-3">
        Требования к паролю:
        <ul>
            <li><span id="length" class='text-danger'>Длина не менее 6 символов</span></li>
            <li><span id="big" class='text-danger'>Прописные латинские буквы</span></li>
            <li><span id="small" class='text-danger'>Строчные латинские буквы</span></li>
            <li><span id="number" class='text-danger'>Цифры</span></li>
            Для большей безопасности рекомендуем в пароле использовать символы.
        </ul>
    </div>
</div>