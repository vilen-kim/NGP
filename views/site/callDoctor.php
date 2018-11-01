<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha;
$this->title = 'Вызов врача на дом';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">

    <div class="col-sm-6 col-sm-offset-3">

        <div style="margin: -30px 0 30px 0">
            <h3 align="center">Показания для вызова врача-терапевта  участкового</h3>
            <ul>
                <li>Повышение температуры тела выше 38,2 &degС.</li>
                <li>Рвота, жидкий стул, боли в животе.</li>
                <li>Острая боль любой локализации.</li>
                <li>Болевой синдром у больных с ишемической болезнью сердца, состояние после пароксизмов нарушения ритма сердца, боли в сердце у больных с гипертонической болезнью и т.д.</li>
                <li>Колебания артериального давления на фоне гипертонической болезни, атеросклероза, стрессовых состояний.</li>
                <li>Температура выше 38 &degC у парализованных больных и больных с хронической патологией.</li>
            </ul>
        </div>

        <?php
            $form = ActiveForm::begin();
            echo $form->field($model, 'fio')->textInput(['placeholder' => 'ФИО'])->label(false);
            echo $form->field($model, 'phone')->textInput(['placeholder' => 'Номер телефона'])->label(false);
            echo $form->field($model, 'address')->textInput(['placeholder' => 'Адрес'])->label(false);
            echo $form->field($model, 'email')->textInput(['placeholder' => 'Электронная почта'])->label(false);
            echo $form->field($model, 'text')->textarea(['placeholder' => 'Опишите самочувствие'])->label(false);
            echo $form->field($model, 'reCaptcha')->widget(ReCaptcha::className())->label(false);
        ?>
        
        <div align="center">
            <?= Html::submitButton('Отправить заявку', ['class' => 'btn btn-008080']) ?>
        </div>
            
        <?php ActiveForm::end() ?>

    </div>

</div>