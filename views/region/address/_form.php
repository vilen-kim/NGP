<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegionAddress */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="region-address-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'street_id')->textInput() ?>

    <?= $form->field($model, 'house')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'house_from')->textInput() ?>

    <?= $form->field($model, 'house_to')->textInput() ?>

    <?= $form->field($model, 'parity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
