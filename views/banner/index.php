<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    $this->title = 'Баннеры';
?>

<h1><?= $this->title ?></h1>

<div style="padding: 10px;">
    <?php
        echo Html::a('Добавить баннер', ['banner/create'], ['class' => 'btn btn-primary', 'style' => 'margin-bottom: 10px']);

        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Изображение',
                    'format' => 'html',
                    'value' => function ($model) {
                        return Html::img(Yii::$app->request->BaseUrl . '/' . $model->image, ['width' => '200px']);
                    }
                ],
                'url:url',
                'main:boolean',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
            ],
        ]);
    ?>
</div>
