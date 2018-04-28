<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

app\assets\AuthAsset::register($this);
$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['auth/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="auth-update">
    <div class="col-md-6">

        <?php
        $form = ActiveForm::begin(['id' => 'update-form']);
        echo $form->field($model, 'username')->textInput(['readOnly' => true]);
        echo $form->field($model, 'password')->passwordInput();
        echo $form->field($model, 'passwordRepeat')->passwordInput();
        echo $form->field($model, 'role')->dropDownList($roles);
        echo Html::submitButton('Изменить', ['class' => 'btn scale', 'style' => 'background: #ffda44; color: black']);
        ActiveForm::end();
        ?>

    </div>
</div>