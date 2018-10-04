<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    $this->title = 'Баннеры';
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <?php
        echo Html::a('Добавить баннер', ['banner/create'], ['class' => 'btn btn-success', 'style' => 'margin-bottom: 10px']);

        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Изображение',
                    'format' => 'html',
                    'value' => function ($model) {
                        return Html::img($model->image, ['width' => '100px']);
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
