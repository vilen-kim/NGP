<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

app\assets\AuthAsset::register($this);
$this->title = 'Восстановление пароля';
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="row">
    <div class="col-md-6 col-md-offset-3 border">

        <?php $form = ActiveForm::begin(['id' => 'forgotpass-form']); ?>
        <?= '<p>Пожалуйста, укажите Ваш электронный адрес. На него будет отправлено письмо с инструкцией по сбросу пароля.</p>' ?>
        <?= $form->field($model, 'email') ?>
        <?= Html::submitButton('Отправить', ['class' => 'btn scale', 'style' => 'background: #ffda44; color: black']) ?>
        <?php ActiveForm::end(); ?>

    </div>
</div>