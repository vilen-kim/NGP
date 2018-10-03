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
    <div style="margin-bottom: 40px">
        <?= Html::a('Создать страницу', Url::to(['pages/create']), ['class' => 'btn btn-008080']) ?>
    </div>

    <?php
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
