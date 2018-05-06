<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

app\assets\RequestAsset::register($this);
$this->title = $model->lastname . ' ' . $model->firstname . ' ' . $model->middlename;
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Адресаты обращений', 'url' => ['request/whom']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">

        <?php $form = ActiveForm::begin(['id' => 'update-form']); ?>
        <?= $form->field($model, 'lastname') ?>
        <?= $form->field($model, 'firstname') ?>
        <?= $form->field($model, 'middlename') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'kab') ?>
        <?= $form->field($model, 'priem') ?>
        <?= $form->field($model, 'position') ?>
        <?= $form->field($model, 'organization') ?>
        <?= Html::submitButton('Изменить', ['class' => 'btn btn-default changeBack']) ?>
        <?php ActiveForm::end(); ?>

    </div>
</div>