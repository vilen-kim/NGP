<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

app\assets\AuthAsset::register($this);
if ($role){
    $this->title = 'Создание нового пользователя';
    $btnText = 'Создать';
    $this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['auth/index']];
    $this->params['breadcrumbs'][] = $this->title;
} else {
    $this->title = 'Регистрация';
    $btnText = 'Регистрация';
}
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="auth-register">
    <div class="col-md-6">

        <?php
        $form = ActiveForm::begin(['id' => 'register-form']);
        echo $form->field($model, 'username');
        echo $form->field($model, 'password')->passwordInput();
        echo $form->field($model, 'passwordRepeat')->passwordInput();
        echo $form->field($model, 'role_id')->textInput();
        echo Html::submitButton($btnText, ['class' => 'btn scale', 'style' => 'background: #ffda44; color: black']);
        ActiveForm::end();
        ?>

    </div>
</div>