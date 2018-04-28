<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="menu-form">

    <?php
    $form = ActiveForm::begin();
    echo $form->field($model, 'caption')->textInput(['maxlength' => true]);
    echo $form->field($model, 'parent_id')->dropDownList($parents);
    echo $form->field($model, 'page_id')->dropDownList($pages, ['prompt' => 'Укажите страницу']);
    echo $form->field($model, 'anchor')->textInput(['maxlength' => true]);
    echo $form->field($model, 'position')->textInput(['type' => 'number']);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
