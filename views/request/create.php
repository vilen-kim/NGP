<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Создание нового адресата обращений';
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Адресаты обращений', 'url' => ['request/whom']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="row">
    <div class="col-md-6 col-md-offset-3 border">

        <?php $form = ActiveForm::begin(['id' => 'create-form']); ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'lastname') ?>
        <?= $form->field($model, 'firstname') ?>
        <?= $form->field($model, 'middlename') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'kab') ?>
        <?= $form->field($model, 'priem') ?>
        <?= $form->field($model, 'position') ?>
        <?= $form->field($model, 'organization') ?>
        <?= Html::submitButton('Создать', ['class' => 'btn btn-default changeBack']) ?>
        <?php ActiveForm::end(); ?>

    </div>
</div>