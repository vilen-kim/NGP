<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    app\assets\AuthAsset::register($this);
    $this->title = 'Вход в личный кабинет';
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <div class="col-md-offset-3 col-md-6">

        <?php
            $form = ActiveForm::begin(['id' => 'login-form']);
            $errorOptions = ['errorOptions' => ['encode' => false, 'class' => 'help-block']];
            echo $form->field($model, 'email', $errorOptions)->textInput(['placeholder' => 'Электронная почта'])->label(false);
            echo $form->field($model, 'password', $errorOptions)->passwordInput(['placeholder' => 'Пароль'])->label(false);
            echo $form->field($model, 'rememberMe')->checkbox();
        ?>
        
        <div class="row">
            <div class="col-md-4">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-008080']) ?>
            </div>
            <div class="col-md-4" align="center" style="padding-top: 6px;">
                <?= Html::a('Зарегистрироваться', ['auth/register'], ['id' => 'aRegister', 'style' => 'color: green']) ?>
            </div>
            <div class="col-md-4" align="right" style="padding-top: 6px;">
                <?= Html::a('Забыли пароль', ['auth/forgot-pass'], ['id' => 'aForgotPass', 'style' => 'color: red']) ?>
            </div>
        </div>
        
            <?php ActiveForm::end(); ?>

    </div>
</div>