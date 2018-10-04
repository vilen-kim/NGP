<?php
    use yii\bootstrap\Modal;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    Modal::begin([
        'id' => 'modalCallComment',
        'header' => "<h2 class='caption'>Добавить комментарий к заявке</h2>",
        'size' => Modal::SIZE_DEFAULT,
        'clientOptions' => [
            'show' => false,
        ],
        'headerOptions' => [
            'style' => [
                'background' => '#008080',
                'color' => 'white',
            ],
        ],
    ]);
?>

<p>
    <b>Дата заявки:</b> <?= Yii::$app->formatter->asDate($model->dateRequest) ?>
</p>
<p>
    <b>Данные пациента:</b><br> <?= $model->patient; ?>
</p>
<div style="margin-top: 20px;">
    <?php
        $form = ActiveForm::begin();
        echo $form->field($model, 'id')->hiddenInput()->label(false);
        echo $form->field($model, 'comment')->textInput(['placeholder' => 'Комментарий'])->label(false);
        $button = Html::submitButton('Добавить', ['class' => 'btn btn-008080']);
        echo Html::tag('div', $button, ['align' => 'center']);        
        ActiveForm::end();
    ?>
</div>

 <?php Modal::end();