<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Вызов врача на дом';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">

    <div class="col-md-6 col-md-offset-3">

        <?php
            $form = ActiveForm::begin();
            echo $form->field($model, 'fio')->textInput(['placeholder' => 'ФИО'])->label(false);
            echo $form->field($model, 'phone')->textInput(['placeholder' => 'Номер телефона'])->label(false);
            echo $form->field($model, 'address')->textInput(['placeholder' => 'Адрес'])->label(false);
            echo $form->field($model, 'email')->textInput(['placeholder' => 'Электронная почта'])->label(false);
            echo $form->field($model, 'text')->textarea(['placeholder' => 'Опишите самочувствие'])->label(false);
        ?>
        
        <div align="center">
            <?= Html::submitButton('Отправить заявку', ['class' => 'btn btn-008080']) ?>
        </div>
            
        <?php ActiveForm::end() ?>

    </div>

</div>