<?php
    use yii\bootstrap\Modal;
    use yii\helpers\Html;

    Modal::begin([
        'id' => 'modalAnswer',
        'header' => "<h2 class='caption'>Ответ на обращение</h2>",
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
    <b>Дата ответа:</b> <?= Yii::$app->formatter->asDate($model->answer_created_at) ?>
</p>
<p>
    <b>Кто ответил:</b> <?= $model->answerAuth->fio ?>
</p>
<p>
    <b>Текст ответа:</b> <?= $model->answer_text ?>
</p>

 <?php Modal::end();
