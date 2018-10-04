<?php
    use yii\bootstrap\Modal;
    use yii\helpers\Html;

    Modal::begin([
        'id' => 'modalCallInfo',
        'header' => "<h2 class='caption'>Информация по заявке</h2>",
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
    <b>Дата закрытия заявки:</b> <?= Yii::$app->formatter->asDate($model->dateWorking) ?>
</p>
<p>
    <b>Кто закрыл:</b> <?= Html::a($model->doctor->fio, ['auth/view', 'id' => $model->doctor->id]) ?>
</p>

 <?php Modal::end();
