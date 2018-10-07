<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    app\assets\AuthAsset::register($this);
    $this->title = 'Восстановление пароля';
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <div class="col-sm-6 col-sm-offset-3 border">

        <?php $form = ActiveForm::begin(['id' => 'forgotpass-form']); ?>
        
        <p>Пожалуйста, укажите Ваш электронный адрес.<br>
           На него будет отправлено письмо с инструкцией по сбросу пароля.</p>
        
        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Электронная почта'])->label(false) ?>
        
        <div class="col-sm-12 text-center">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-008080']) ?>
        </div>
            
        <?php ActiveForm::end(); ?>

    </div>
</div>