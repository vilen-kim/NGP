<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

app\assets\AuthAsset::register($this);
$this->title = 'Регистрация';
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="auth-register">
    <div class="col-md-6">

        <?php
        $form = ActiveForm::begin(['id' => 'register-form']);
        echo $form->field($model, 'username');
        echo $form->field($model, 'password')->passwordInput();
        echo $form->field($model, 'passwordRepeat')->passwordInput();
        echo Html::submitButton('Регистрация', ['class' => 'btn scale', 'style' => 'background: #ffda44; color: black']);
        ActiveForm::end();
        ?>

    </div>
</div>