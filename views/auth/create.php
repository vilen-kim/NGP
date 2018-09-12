<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use himiklab\yii2\recaptcha\ReCaptcha;
    app\assets\AuthAsset::register($this);
    $this->title = 'Создание нового пользователя';
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <div class="col-md-6 col-md-offset-3">

        <?php $form = ActiveForm::begin(); ?>
        
        <h2 class="text-center" style="margin-top: 0">Учетная запись</h2>
        <?php
            echo $form->field($model, 'email')->textInput(['placeholder' => 'Электронная почта'])->label(false);
            echo $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false);
            echo $form->field($model, 'passwordRepeat')->passwordInput(['placeholder' => 'Повторите пароль'])->label(false);
            echo $form->field($model, 'role')->dropDownList($roles)->label(false);
        ?>
        
        <h2 class="text-center">Профиль</h2>
        <?php
            echo $form->field($model, 'lastname')->textInput(['placeholder' => 'Фамилия'])->label(false);
            echo $form->field($model, 'firstname')->textInput(['placeholder' => 'Имя'])->label(false);
            echo $form->field($model, 'middlename')->textInput(['placeholder' => 'Отчество'])->label(false);
        ?>
        
        <h2 class="text-center">Должностное лицо</h2>
        <?php
            echo $form->field($model, 'executive')->checkbox();
            echo $form->field($model, 'position')->textInput(['placeholder' => 'Должность'])->label(false);
            echo $form->field($model, 'kab')->textInput(['placeholder' => 'Кабинет'])->label(false);
            echo $form->field($model, 'priem')->textInput(['placeholder' => 'Время приема'])->label(false);
        ?>
        
        <div class="col-md-12" align="center">
            <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::className())->label(false) ?>
        </div>
        <div class="col-md-12" align="center">
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary']) ?>
        </div>
        
        <?php ActiveForm::end(); ?>

    </div>
    <div class="col-md-3" style="padding-top: 91px;">
        Требования к паролю:
        <ul>
            <li><span id="length" class='text-danger'>Длина не менее 6 символов</span></li>
            <li><span id="big" class='text-danger'>Прописные латинские буквы</span></li>
            <li><span id="small" class='text-danger'>Строчные латинские буквы</span></li>
            <li><span id="number" class='text-danger'>Цифры</span></li>
        </ul>
    </div>
</div>