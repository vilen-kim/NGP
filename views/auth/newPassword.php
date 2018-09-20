<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    app\assets\AuthAsset::register($this);
    $this->title = 'Восстановление пароля';
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <p>Введите новый пароль для учетной записи <b><?= $email ?></b>:</p>
        
        <?php
            $form = ActiveForm::begin();
            echo $form->field($model, 'password')->passwordInput(['id' => 'password', 'placeholder' => 'Пароль'])->label(false);
            echo $form->field($model, 'passwordRepeat')->passwordInput(['placeholder' => 'Повторите пароль'])->label(false);
        ?>
        <div class="col-md-12" align="center">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        
    </div>
    <div class="col-md-3" style="padding-top: 35px;">
        Требования к паролю:
        <ul>
            <li><span id="length" class='text-danger'>Длина не менее 6 символов</span></li>
            <li><span id="big" class='text-danger'>Прописные латинские буквы</span></li>
            <li><span id="small" class='text-danger'>Строчные латинские буквы</span></li>
            <li><span id="number" class='text-danger'>Цифры</span></li>
        </ul>
    </div>
</div>