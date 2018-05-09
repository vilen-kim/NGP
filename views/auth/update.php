<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha;

app\assets\AuthAsset::register($this);
$this->title = $model->lastname . ' ' . $model->firstname . ' ' . $model->middlename;
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['auth/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">

        <?php $form = ActiveForm::begin(['id' => 'update-form']); ?>
        
        <h4 class="text-center"><b>Учетная запись:</b></h4>
        <?= $form->field($model, 'email')->textInput(['readOnly' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>
        <?= $form->field($model, 'role')->dropDownList($roles) ?>
        
        <h4 class="text-center"><b>Профиль:</b></h4>
        <?= $form->field($model, 'lastname') ?>
        <?= $form->field($model, 'firstname') ?>
        <?= $form->field($model, 'middlename') ?>
        
        <h4 class="text-center"><b>Должностное лицо:</b></h4>
        <?= $form->field($model, 'executive')->checkbox() ?>
        <?= $form->field($model, 'position') ?>
        <?= $form->field($model, 'kab') ?>
        <?= $form->field($model, 'priem') ?>
        
        <?= Html::submitButton('Изменить', ['class' => 'btn btn-default changeBack']) ?>
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