<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\grid\GridView;
    use yii\widgets\Pjax;
    app\assets\PageAsset::register($this);
    $this->title = 'Страницы';
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <?php
    echo Html::a('Создать страницу', ['pages/create'], ['class' => 'btn btn-success', 'style' => 'margin-bottom: 10px']);

    Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'contentOptions' => [
                'style' => 'white-space: normal',
            ],
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'caption',
            'categoryCaption',
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width: 70px;'],
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '', [
                            'onClick' => "del($model->id)",
                            'title' => 'Удалить',
                        ]);
                    },
                ],
            ],
        ],
    ]);
    Pjax::end();
    ?>
</div>
