<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha;

app\assets\AuthAsset::register($this);
$this->title = 'Регистрация';
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="row">
    <div class="col-md-6 col-md-offset-3 border">
        
        <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput(['id' => 'password']) ?>
        <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>
        <?= $form->field($model, 'lastname') ?>
        <?= $form->field($model, 'firstname') ?>
        <?= $form->field($model, 'middlename') ?>
        <div class="col-md-12">
            <div class="pull-left">
                <?= $form->field($model, 'reCaptcha')->widget(
                    ReCaptcha::className())->label(false) ?>
            </div>
            <div class="pull-right">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-default changeBack']) ?>
            </div>
        </div>
        <div class="col-md-12 text-justify small">
            В соответствии с Федеральным законом № 152-ФЗ «О персональных данных» от 27.07.2006,
            отправляя данную форму, Вы подтверждаете свое <?= Html::a('согласие на обработку персональных данных', '') ?>.
            Обработка персональных данных осуществляется в соответствии с <?= Html::a('"Политикой оператора в отношении обработки персональных данных"', ['site/show', 'id' => 12]) ?>.
        </div>
        <?php ActiveForm::end(); ?>
        

    </div>
    <div class="col-md-3">
        Требования к паролю:
        <ul>
            <li><span id="length" class='text-danger'>Длина не менее 6 символов</span></li>
            <li><span id="big" class='text-danger'>Прописные латинские буквы</span></li>
            <li><span id="small" class='text-danger'>Строчные латинские буквы</span></li>
            <li><span id="number" class='text-danger'>Цифры</span></li>
        </ul>
        Для большей безопасности рекомендуем в пароле использовать символы.
    </div>
</div>