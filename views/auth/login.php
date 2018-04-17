<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

app\assets\AuthAsset::register($this);
$this->title = 'Вход в панель управления';
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="auth-login">
    <div class="col-md-6">

        <?php
        $form = ActiveForm::begin(['id' => 'login-form']);
        echo $form->field($model, 'username', ['errorOptions' => ['encode' => false, 'class' => 'help-block']]);
        echo $form->field($model, 'password', ['errorOptions' => ['encode' => false, 'class' => 'help-block']])->passwordInput();
        echo $form->field($model, 'rememberMe')->checkbox();
        ?>
        <div class="row">
            <div class="col-lg-4">
                <?= Html::submitButton('Войти', ['class' => 'btn scale', 'style' => 'background: #ffda44; color: black']) ?>
            </div>
            <div class="col-lg-4" align="center">
                <?= Html::a('Зарегистрироваться', Url::to(['auth/register']), ['id' => 'aRegister', 'style' => 'color: green']) ?>
            </div>
            <div class="col-lg-4" align="right">
                <?= Html::a('Забыли пароль', Url::to(['auth/forgot-pass']), ['id' => 'aForgotPass', 'style' => 'color: red']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>