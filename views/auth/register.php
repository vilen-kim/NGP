<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use himiklab\yii2\recaptcha\ReCaptcha;
    app\assets\AuthAsset::register($this);
    $this->title = 'Регистрация';
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <div class="col-md-6 col-md-offset-3 border">

        <?php
            $form = ActiveForm::begin(['id' => 'register-form']);
            echo $form->field($model, 'email')->textInput(['placeholder' => 'Электронная почта'])->label(false);
            echo $form->field($model, 'password')->passwordInput(['id' => 'password', 'placeholder' => 'Пароль'])->label(false);
            echo $form->field($model, 'passwordRepeat')->passwordInput(['placeholder' => 'Повторите пароль'])->label(false);
            echo $form->field($model, 'lastname')->textInput(['placeholder' => 'Фамилия'])->label(false);
            echo $form->field($model, 'firstname')->textInput(['placeholder' => 'Имя'])->label(false);
            echo $form->field($model, 'middlename')->textInput(['placeholder' => 'Отчество'])->label(false);
        ?>
        <div class="col-md-4">
            <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::className(), ['size' => 'compact'])->label(false) ?>
        </div>
        <div class="col-md-8 text-justify" style="font-size: small">
            В соответствии с Федеральным законом № 152-ФЗ «О персональных данных» от 27.07.2006,
            отправляя данную форму, Вы подтверждаете свое <?= Html::a('согласие на обработку персональных данных', '') ?>.
            Обработка персональных данных осуществляется в соответствии с <?= Html::a('"Политикой оператора в отношении обработки персональных данных"', ['site/show', 'id' => 12]) ?>.
        </div>
        <div class="col-md-12 text-center">
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
    <div class="col-md-3" style="padding-top: 55px;">
        Требования к паролю:
        <ul>
            <li><span id="length" class='text-danger'>Длина не менее 6 символов</span></li>
            <li><span id="big" class='text-danger'>Прописные латинские буквы</span></li>
            <li><span id="small" class='text-danger'>Строчные латинские буквы</span></li>
            <li><span id="number" class='text-danger'>Цифры</span></li>
        </ul>
    </div>
</div>